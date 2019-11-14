<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $fillable = [
        'name', 'value'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function findByValue($value) {
        $timezone = Timezone::where('value', $value)->first();
        return $timezone;
    }
}
