<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSessionMeta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'status', 'country', 'countryCode', 'region', 'regionName', 'city', 'zip',
        'lat', 'lon', 'timezone', 'isp', 'org', 'as', 'query', 'user_session_id'
    ];


}
