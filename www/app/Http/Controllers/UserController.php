<?php

namespace App\Http\Controllers;

use Adldap\AdldapInterface;
use App\Libs\Avatar;
use App\Libs\Ldap;
use App\User;
use App\UserSession;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    protected $ldap;

    public function __construct(AdldapInterface $ldap) {
        $this->ldap = $ldap;
    }
    public function getUsers() {
        return view('pages.accounts.user-accounts');
    }

    public function getUser($user_uid) {
        return view('pages.accounts.user-account');
    }

    public function getUsersApi()
    {
        $users = DB::table('users')
            ->leftJoin('user_types as ut', 'users.user_type_id', '=', 'ut.id')
            ->select('*', 'ut.name as user_type_name', 'users.name as name',
                'users.id as id')
            ->get();

        foreach($users as $user) {
            $tmpUser = User::where('id', $user->id)->first();
            $roles = $tmpUser->getRoleNames();
            $user->avatar_url = Avatar::render($user->email);
            $user->meta = [
                'roles' => $roles,
                'sessions' => UserSession::where('user_id', $user->id)->first(),
            ];
            $user->timezone = $tmpUser->getTimezone();
        }

        return datatables($users)->toJson();
    }

    public function getUserApi($uid)
    {
        $users = DB::table('users')
            ->leftJoin('user_types as ut', 'users.user_type_id', '=', 'ut.id')
            ->where('users.uid', $uid)
            ->select('*', 'ut.name as user_type_name', 'users.name as name',
                'users.id as id')
            ->get();

        foreach($users as $user) {
            $ldap = '';
            $tmpUser = User::where('id', $user->id)->first();
            $roles = $tmpUser->getRoleNames();
            $user->avatar_url = Avatar::render($user->email);
            if ($user->ldap_user) {
                $ldapUser = $this->ldap->search()->where('mail', $user->email)->first();
                $ldap = [
                    'cn' => $ldapUser['cn'][0],
                    'mail' => $ldapUser['mail'][0],
                    'givenname' => $ldapUser['givenname'][0],
                    'sn' => $ldapUser['sn'][0],
                    'uid' => $ldapUser['uid'][0],
                    'dn' => $ldapUser['distinguishedname'][0]
                ];
            }
            $user->meta = [
                'ldap' => $ldap,
                'roles' => $roles,
                'sessions' => UserSession::where('user_id', $user->id)->first(),
            ];
            $user->timezone = $tmpUser->getTimezone();
        }
        return datatables($users)->toJson();
    }

    public function postUserApi($uid) {
        $user = User::findByUid($uid);

        $user->update([
            request('field') => request('value')
        ]);

        if ($user->save()) {
            return [
                'success' => true,
                'message' => 'Updated user successfully'
            ];
        }
    }

    public function getUserActivitiesApi($uid) {
        $user = User::findByUid($uid);
        $activities = Activity::where('subject_type', 'App\User')
            ->where('subject_id', $user->id)
            ->orderBy('created_at', 'desc')->get();

        if (request()->has('limit'))
        {
            $activities = Activity::where('subject_type', 'App\User')
                ->where('subject_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(request('limit'))->get();
        }

       return response()->json($activities);
    }
}
