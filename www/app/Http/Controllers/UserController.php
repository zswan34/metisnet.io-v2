<?php

namespace App\Http\Controllers;

use App\User;
use App\UserType;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsers() {
        return view('pages.accounts.user-accounts');
    }

    public function getUsersApi()
    {
        $query = DB::table('users')
            ->leftJoin('user_types as ut', 'users.user_type_id', '=', 'ut.id')
            ->select('*', 'ut.name as user_type_name', 'users.name as name')
            ->get();
        return datatables($query)->toJson();
    }

    public function getUserApi($uid)
    {
        $query = DB::table('users')
            ->leftJoin('user_types as ut', 'users.user_type_id', '=', 'ut.id')
            ->where('users.uid', $uid)
            ->select('*', 'ut.name as user_type_name', 'users.name as name')
            ->get();
        return datatables($query)->toJson();
    }
}
