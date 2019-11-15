<?php

namespace App\Http\Controllers;

use Adldap\AdldapInterface;
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
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been locked. Contact your administrator to unlock your account.'
                ]);
            }
            $response = [
                'success' => true,
                'message' => 'Logged in successfully',
                'redirect' => redirect()->intended()->getTargetUrl()
            ];

            auth()->user()->session()->create();

            return response()->json($response, 200);
        }
        else {
            return $this->failedAuthAttempt($email);
        }
    }

    protected function failedAuthAttempt($email)
    {
        if ($user = User::where('email', $email)->first()) {

            if ($user->login_attempts > $this->max_attempts) {
                if (!$user->locked) {
                    $user->update([
                        'locked' => 1
                    ]);
                    $user->save();
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been locked. Contact your administrator to unlock your account.'
                ]);
            } else {

                $user->update([
                    'login_attempts' => $user->login_attempts + 1
                ]);
                $user->save();

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

                    auth()->loginUsingId($user->id);

                    auth()->user()->update([
                        'ldap_user' => true,
                        'username' => $ldapUser->uid[0],
                        'pkcs12' => false
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
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect email and password combination'
                ]);
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
            return true;
        } else {
            return false;
        }
    }

    protected function attemptLAuth($email, $password, $remember) {
        if ($ldapUser = $this->ldap->search()->where('mail', $email)->first()) {
            $userDN = 'uid='.$ldapUser->uid[0].','.config('ldap.connections.default.settings.base_dn');

            if($this->ldap->auth()->attempt($userDN, $password, $bindAsUser = true)) {
                if (!$user = User::where('email', $email)->first()) {
                    auth()->loginUsingId($user->id);
                } else {
                    auth()->user()->update([
                        'ldap_user' => true,
                        'username' => $ldapUser->uid[0],
                        'pkcs12' => false
                    ]);

                    if (is_null(auth()->user()->email_verified_at)) {
                        auth()->user()->update(['email_verified_at' => now()]);
                        auth()->user()->save();
                    }

                    auth()->user()->update([
                        'last_login' => Carbon::now(),
                        'api_token' => $this->api_token,
                        'token_2fa_expiry' => Carbon::now()
                    ]);
                    auth()->user()->save();
                    $response = [
                        'success' => true,
                        'data' => [
                            'user' => auth()->user(),
                        ],
                        'redirect' => route('get-verify', ['ref' => 'sign-in']),
                        'api_token' => $this->api_token
                    ];

                    $response['redirect'] = redirect()->intended()->getTargetUrl();
                    if (request()->has('url')) {
                        $response['redirect'] = request()->get('url');
                    }
                    $status = 200;
                    activity()->by(auth()->user())->on(auth()->user())
                        ->withProperties(['auth' => 'success', 'user' => ['uid' => auth()->user()->uid]])
                        ->log('User authenticated successfully from ldap.');
                }
                if (!$user) {
                    $user = new User();
                    $user->name = $ldapUser->cn[0];
                    $user->email = $ldapUser->mail[0];
                    $user->username = $ldapUser->uid[0];
                    $user->password = bcrypt($password);
                    $user->email_verified_at = now();
                    $user->ldap_user = true;
                    $user->disadvantaged = $this->disadvantaged;
                    if($user->save())
                    {
                        auth()->loginUsingid($user->id);
                        $response = [
                            'success' => true,
                            'data' => [
                                'user' => auth()->user(),
                            ],
                            'redirect' => route('get-verify', ['ref' => 'sign-in']),
                            'api_token' => $this->api_token
                        ];
                        if (!is_null(auth()->user()->email_verified_at)) {
                            auth()->user()->update([
                                'last_login' => Carbon::now(),
                                'api_token' => $this->api_token,
                                'token_2fa_expiry' => Carbon::now()
                            ]);
                            auth()->user()->save();

                            $response['redirect'] = redirect()->intended()->getTargetUrl();
                            if (request()->has('url')) {
                                $response['redirect'] = request()->get('url');
                            }
                        }

                        $status = 200;
                        activity()->by(auth()->user())->on(auth()->user())
                            ->withProperties(['auth' => 'success', 'user' => ['uid' => auth()->user()->uid]])
                            ->log('User authenticated successfully from ldap.');
                    } else {
                        // User not saved
                        return json_encode(['user' => 'not signed in']);
                    }
                } else {
                    auth()->loginUsingid($user->id);
                    auth()->user()->update([
                        'ldap_user' => true,
                        'username' => $ldapUser->uid[0],
                        'pkcs12' => false
                    ]);
                    //auth()->user()->save();

                    if (is_null(auth()->user()->email_verified_at)) {
                        auth()->user()->update(['email_verified_at' => now()]);
                        auth()->user()->save();
                    }
                    auth()->user()->update([
                        'last_login' => Carbon::now(),
                        'api_token' => $this->api_token,
                        'token_2fa_expiry' => Carbon::now()
                    ]);
                    auth()->user()->save();

                    $response = [
                        'success' => true,
                        'data' => [
                            'user' => auth()->user(),
                        ],
                        'redirect' => route('get-verify', ['ref' => 'sign-in']),
                        'api_token' => $this->api_token
                    ];

                    $response['redirect'] = redirect()->intended()->getTargetUrl();
                    if (request()->has('url')) {
                        $response['redirect'] = request()->get('url');
                    }

                    $status = 200;
                    activity()->by(auth()->user())->on(auth()->user())
                        ->withProperties(['auth' => 'success', 'user' => ['uid' => auth()->user()->uid]])
                        ->log('User authenticated successfully from ldap.');
                }
            } else {
                $response = [
                    'success' => false,
                    'data' => [
                        'message' => 'Incorrect email and password combination'
                    ]
                ];
                $status = 401;
                activity()->withProperties(['auth' => 'failed', 'email' => $email])
                    ->log('Authentication attempt failed against ldap.');
                TODO: //
            }
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
                'permissions' => json_decode($user->getPermissionsViaRoles())
            ]
        ];

    }

    public function postForgotPassword() {

    }
}
