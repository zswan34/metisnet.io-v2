<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'uuid', 'name', 'original_filename', 'extension', 'size', 'upload_id',
        'restriction_id', 'classification_id', 'file_type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function upload() {
        return $this->belongsTo(Upload::class);
    }
}
