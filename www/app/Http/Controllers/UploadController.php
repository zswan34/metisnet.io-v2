<?php

namespace App\Http\Controllers;

use App\File;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class UploadController extends Controller
{
    public function avatarUpload() {
        if (request()->hasFile('avatar')) {
            $file = request()->file('avatar');
            $extension = $file->extension();
            $clientOriginalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $filename = str_replace('.', '^', $clientOriginalName);
            $filename = array_slice(explode('^', $filename), 0, -1); // array ( "Hello", "World" )
            $filename = implode("", $filename);
            $filename = time();
            $uuid = Uuid::uuid4();
            Storage::disk('public')->putFileAs(
                'accounts/'. auth()->user()->account->uuid . '/'. auth()->user()->uid . '/avatar/' . time() , $file, $clientOriginalName
            );
            $upload = new Upload();
            $upload->user_id = auth()->user()->id;
            $upload->save();

            $file = new File();
            $file->uuid = $uuid;
            $file->name = $filename;
            $file->original_filename = $clientOriginalName;
            $file->extension = $extension;
            $file->size = $size;
            $file->upload_id = $upload->id;

            $file->save();

            auth()->user()->update(['avatar_file_id' => $file->id]);
                auth()->user()->save();

            return [
                'success' => true,
                'id' => $file->id
            ];
        }
    }
}
