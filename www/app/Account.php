<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uid', 'uuid', 'nickname', 'setup_complete', 'user_id'
    ];

    public function userAccounts() {
        return $this->hasMany(UserAccount::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function isSetup() {
        return ($this->getAttribute('setup_complete'));
    }
}
