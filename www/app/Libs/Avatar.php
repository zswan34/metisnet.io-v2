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
                    $avatar = File::find($user->avatar_file_id);
                    self::$avatar = url('storage/accounts/' . $user->account->uuid . '/' . $user->uid . '/avatar/' . $avatar->name. '/' . $avatar->original_filename);
                } else {
                    self::$avatar = gravatar()->avatar($email);
                }
            } else {
                self::$avatar = gravatar()->avatar($email);
            }
        }
        else
        {
            if (auth()->check()) {
                if (!is_null(auth()->user()->avatar_file_id)) {
                    $avatar = File::find(auth()->user()->avatar_file_id);
                    self::$avatar = url('storage/accounts/' . auth()->user()->account->uuid . '/' . auth()->user()->uid . '/avatar/' . $avatar->name . '/' . $avatar->original_filename);
                    //self::$avatar = Image::make(self::$avatar)->resize(300, 300);

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