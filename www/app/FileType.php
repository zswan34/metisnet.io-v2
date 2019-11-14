<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    protected $fillable = [
        'name', 'extension'
    ];
}
