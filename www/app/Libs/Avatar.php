<?php

namespace App\Libs;


use App\File;
use App\User;
use Intervention\Image\Image;

class Avatar
{
    protected static $avatar;

    public static function render($email = null)
    {
        self::$avatar = 'assets/img/avatars/holder1.png';

        if (!is_null($email))
        {
            if ($user = User::where('email', $email)->first()) {
                if (!is_null($user->avatar_file_id)) {
                    self::$avatar = url($user->getAvatarUrl());
                } else {
                    self::$avatar = gravatar()->avatar($email)->getUrl();
                }
            } else {
                self::$avatar = gravatar()->avatar($email);
            }
        }
        else
        {
            if (auth()->check()) {
                if (!is_null(auth()->user()->avatar_file_id)) {
                    self::$avatar = url(auth()->user()->getAvatarUrl());
                } else {
                    if (gravatar(auth()->user()->email)) {
                        self::$avatar = gravatar(auth()->user()->email);
                    }
                }
            }
        }
        return self::$avatar;
    }
}