<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PKI extends Model
{
    protected $table = 'pkis';

    protected $fillable = [
        'user_id',
        'expires_at',
        'created_by'
    ];
}
