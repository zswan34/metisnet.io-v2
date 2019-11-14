<?php 

namespace App\Libs;

use App\Timezone;
use App\User;
use Carbon\Carbon;

class Time {

    public static function getLocal($format = 'l, F jS, Y') {
        if (auth()->check()) {
            $timezone = Timezone::find(auth()->user()->timezone_id);
            $time = Carbon::now($timezone->value)->format($format);
            return $time;
        }
    }

    public static function getLocalByUserId($id, $format = 'l, F jS, Y') {
        $user = User::find($id);
        $timezone = Timezone::find($user->timezone_id);
        $time = Carbon::now($timezone->value)->format($format);
        return $time;

    }

}