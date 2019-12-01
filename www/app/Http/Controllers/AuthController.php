<?php

namespace App\Http\Controllers;

use Adldap\AdldapInterface;
use App\Libs\Meta;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $ldap;
    protected $attempts;
    protected $max_attempts;

    public function __construct(AdldapInterface $ldap)
    {
        $this->attempts = 1;
        $this->max_attempts = 5;
        $this->ldap = $ldap;
    }

    public function getSignIn()
    {
        return view('auth.sign-in');
    }

    public function postSignIn()
    {
        $email = request('email');
        $password = request('password');
        $remember = (request('remember'));

        if (!$this->emailHasLdap($email)) {
            return $this->attemptAuth($email, $password, $remember);
        }

        if ($this->emailHasLdap($email)) {
            return $this->attemptLdapAuth($email, $password, $remember);
        }

        return response()->json([
            'success' => false,
            'message' => 'An unknown error occurred'
        ]);
    }

    protected function emailHasLdap($email) {
        return ($this->ldap->search()->where('mail', $email)->first());
    }

    protected function attemptAuth($email, $password, $remember) {
        if (auth()->attempt(['email' => $email, 'password' => $password], $remember)) {

            if (auth()->user()->locked) {
                auth()->logout();
                return $this->failedAuthAttempt($email, 'email_password');
            }
            Meta::saveDataFromAuthUser();
            $response = [
                'success' => true,
                'message' => 'Logged in successfully',
                'redirect' => redirect()->intended()->getTargetUrl()
            ];

            $session = auth()->user()->session()->create();

            activity('auth')
                ->on(User::find(auth()->user()->id))
                ->withProperties([
                    'uid' => auth()->user()->uid,
                    'auth_type' => 'email_password',
                    'session' => $session])
                ->log('Authenticated successfully');

            return response()->json($response, 200);
        }
        else {
            return $this->failedAuthAttempt($email, 'email_password');
        }
    }

    protected function failedAuthAttempt($email, $type)
    {
        if ($user = User::where('email', $email)->first()) {
            if ($user->login_attempts > $this->max_attempts) {
                if (!$user->locked) {
                    $user->update([
                        'locked' => 1
                    ]);
                    $user->save();
                }

                $session = $user->session()->create();

                activity('auth-failed')
                    ->on($user)
                    ->causedBy($user)
                    ->withProperties([
                        'uid' => $user->uid,
                        'account_locked' => true,
                        'auth_type' => $type,
                        'session' => $session])
                    ->log('Authenticated failed');

                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been locked. Contact your administrator to unlock your account.'
                ]);

            } else {

                $user->update([
                    'login_attempts' => $user->login_attempts + 1
                ]);

                $user->save();

                $session = $user->session()->create();

                activity('auth-failed')
                    ->on($user)
                    ->causedBy($user)
                    ->withProperties([
                        'uid' => $user->uid,
                        'account_locked' => false,
                        'auth_type' => $type,
                        'session' => $session])
                    ->log('Authenticated failed');

                $response = [
                    'success' => false,
                    'message' => 'Incorrect email and password combination',
                ];
                return response()->json($response, 200);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Incorrect email and password combination',
            ];
            return response()->json($response, 200);
        }
    }

    protected function attemptLdapAuth($email, $password, $remember)
    {

        if ($ldapUser = $this->ldap->search()->where('mail', $email)->first()) {
            $userDN = 'uid=' . $ldapUser->uid[0] . ',' . config('ldap.connections.default.settings.base_dn');

            if ($this->ldap->auth()->attempt($userDN, $password, $bindAsUser = true)) {

                if (!$user = User::where('email', $email)->first()) {
                    if ($this->createUserFromLdap($email, $password)) {
                        return $this->attemptAuth($email, $password, $remember);
                    }
                } else {
                    auth()->loginUsingId($user->id, $remember);

                    auth()->user()->update([
                        'ldap_user' => true,
                        'username' => $ldapUser->uid[0],
                        'pkcs12' => null
                    ]);

                    if (is_null(auth()->user()->email_verified_at)) {
                        auth()->user()->update(['email_verified_at' => now()]);
                        auth()->user()->save();
                    }

                    auth()->user()->update([
                        'last_login' => Carbon::now(),
                        'token_2fa_expiry' => Carbon::now()
                    ]);
                    auth()->user()->save();

                    $session = auth()->user()->session()->create();

                    activity('auth')
                        ->on(User::find(auth()->user()->id))
                        ->withProperties([
                            'uid' => auth()->user()->uid,
                            'auth_type' => 'ldap',
                            'session' => $session])
                        ->log('Authenticated successfully');

                    $response = [
                        'success' => true,
                        'data' => [
                            'user' => auth()->user(),
                        ],
                        'redirect' => redirect()->intended()->getTargetUrl()
                    ];

                    return response()->json($response, 200);

                }
            } else {
                return $this->failedAuthAttempt($email, 'ldap');
            }
        }
    }

    protected function createUserFromLdap($email, $password) {
        $ldapUser = $this->ldap->search()->where('mail', $email)->first();
        $user = new User();
        $user->name = $ldapUser->cn[0];
        $user->email = $ldapUser->mail[0];
        $user->password = bcrypt($password);
        $user->email_verified_at = now();
        $user->ldap_user = true;
        $user->disadvantaged = true;

        if($user->save()) {
            $session = $user->session()->create();
            activity('user-created')
                ->on($user)
                ->withProperties([
                    'uid' => $user->uid,
                    'created_from' => 'ldap',
                    'created_by' => null,
                    'session' => $session])
                ->log('User created successfully');
            return true;
        } else {
            return false;
        }
    }

    protected function createUser() {

    }

    public function getForgotPassword() {
        return view('auth.forgot-password');
    }

    public function getAuthUserApi() {
        $user = User::find(auth()->user()->id);
        return [
            'auth' => [
                'user' => $user,
                'roles' => $user->getRoleNames(),
                'permissions' => json_decode($user->getPermissionsViaRoles()),
                'timezone' => $user->getTimezone()
            ]
        ];

    }

    public function postForgotPassword() {

    }
}
