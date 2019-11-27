<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'name', 'address_line_one', 'address_line_two', 'suite', 'city', 'state', 'country',
        'phone_primary', 'phone_secondary'
    ];
}
