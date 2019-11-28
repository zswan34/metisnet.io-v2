<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'browser', 'browser_version', 'device', 'platform', 'platform_version',
        'ip_address', 'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function userSessionMetas() {
        return $this->hasMany(UserSessionMeta::class);
    }
}
