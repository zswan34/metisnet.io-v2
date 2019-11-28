<?php

namespace App\Http\Controllers;

use App\Account;
use App\FooterColor;
use App\Libs\DigitalOcean;
use App\Libs\GeoLocate;
use App\Libs\Meta;
use App\Libs\ServerStatus;
use App\Libs\Time;
use App\NavbarColor;
use App\SidenavColor;
use App\Timezone;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class AccountController extends Controller
{
    public function index() {
        $locationData = GeoLocate::fetchClient();
        return response()->json($locationData['as']);
        return view('index');
    }

    public function getSetup() {
        return view('auth.setup');
    }

    public function postSetup() {

        $timezone = request('timezone');
        $recoverEmail = request('secondary-email');
        $tz = Timezone::findByValue($timezone);

        auth()->user()->update([
            'timezone_id' => $tz->id,
            'recovery_email' => $recoverEmail
        ]);

        auth()->user()->save();

        auth()->user()->account->update([
            'setup_complete' => true
        ]);

        if (auth()->user()->account->save()) {
            Meta::saveDataFromAuthUser();

            $response = [
                'success' => true,
                'message' => 'Account created successfully'
            ];

            return response()->json($response, 200);
        }

        $response = [
            'success' => false,
            'message' => 'Failed to create account'
        ];

        return response()->json($response, 200);
    }

    public function getCreateAccount() {
        return view('auth.create-account');
    }

    public function postCreateAccount() {
        $agent = new Agent();

        $name = request('name');
        $email = request('email');
        $phone = request('phone');
        $password = bcrypt(request('password'));

        if (User::where('email', $email)->exists()) {
            // Log user activity
            $properties = [
                'client_ip_address' => request()->getClientIp(),
                'platform' => $agent->platform(),
                'platform_version' => $agent->version($agent->platform()),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'device' => $agent->device()
            ];

            activity()
                ->withProperties($properties)
                ->log('An attempt to create a duplicate account occurred.');

            return [
                'success' => false,
                'message' => 'An account with this email already exists'
            ];
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = $password;

        if ($user->save()) {
            $response =  [
                'success' => true,
                'message' => 'User created successfully',
            ];

            $properties = [
                'client_ip_address' => request()->getClientIp(),
                'platform' => $agent->platform(),
                'platform_version' => $agent->version($agent->platform()),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'device' => $agent->device(),
                'user' => $user
            ];

            activity()
                ->withProperties($properties)
                ->log('Created user successfully');

            return response()->json($response, 201);
        } else {
            $properties = [
                'client_ip_address' => request()->getClientIp(),
                'platform' => $agent->platform(),
                'platform_version' => $agent->version($agent->platform()),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'device' => $agent->device(),
                'user' => $user
            ];
            activity()
                ->withProperties($properties)
                ->log('Unable to create user');

            $response =  [
                'success' => false,
                'message' => 'Unable to create user',
            ];

            return response()->json($response, 200);
        }
    }

    public function getAccount($account_uid) {
        if (!$account = Account::where('uid', $account_uid)->first()) {
            return abort(404);
        }

        return response()->json($account);
    }

    public function getMyAccount() {
        $sidenav_colors = SidenavColor::all();
        $navbar_colors = NavbarColor::all();
        $footer_colors = FooterColor::all();

        $data = [
            'sidenav_colors' => $sidenav_colors,
            'navbar_colors' => $navbar_colors,
            'footer_colors' => $footer_colors
        ];

        return view('my-account', $data);
    }

    public function logout() {
        auth()->logout();
        return redirect()->route('get-sign-in');
    }
}
