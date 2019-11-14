<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorClass extends Model
{
    protected $fillable = [
        'name', 'value', 'type'
    ];
}
