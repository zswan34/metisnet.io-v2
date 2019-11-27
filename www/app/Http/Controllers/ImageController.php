<?php

namespace App\Http\Controllers;

use App\File;
use App\User;

class ImageController extends Controller
{
    public function getAvatar($user_uid, $uuid, $name) {
        $user = User::where('uid', $user_uid)->first();
        $avatar = File::where('uuid', $uuid)
            ->where('name', $name)->first();
        if ($avatar) {
            $storage_path = storage_path('app/public/accounts/' . $user->account->uuid . '/' . $user->uid . '/avatar/' . $avatar->name. '/' . $avatar->original_filename);
            return \Intervention\Image\Facades\Image::make($storage_path)->response();
        }
    }
}
