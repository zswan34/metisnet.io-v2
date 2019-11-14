<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers() {
        return view('users');
    }

    public function getUsersApi() {
        return User::all();
    }
}
