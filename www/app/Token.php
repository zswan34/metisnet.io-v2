<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use  SoftDeletes;

    protected $fillable = [
        'value', 'type', 'expires_on', 'user_id'
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
