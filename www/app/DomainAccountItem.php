<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomainAccountItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'uid', 'domain_account_id', 'type', 'api_key',
        'api_secret'
    ];
}
