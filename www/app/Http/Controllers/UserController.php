<?php

namespace App\Http\Controllers;

use App\Libs\Avatar;
use App\User;
use App\UserType;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
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
            ->select('*', 'ut.name as user_type_name', 'users.name as name')
            ->get();

        foreach($users as $user) {
            $user->avatar_url = Avatar::render($user->email);;
        }

        return datatables($users)->toJson();
    }

    public function getUserApi($uid)
    {
        $users = DB::table('users')
            ->leftJoin('user_types as ut', 'users.user_type_id', '=', 'ut.id')
            ->where('users.uid', $uid)
            ->select('*', 'ut.name as user_type_name', 'users.name as name')
            ->get();

        foreach($users as $user) {
            $user->avatar_url = Avatar::render($user->email);;
        }

        return datatables($users)->toJson();
    }
}
