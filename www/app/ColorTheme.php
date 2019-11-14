<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorTheme extends Model
{
    protected $fillable = [
        'name', 'value', 'href', 'href_material', 'colors'
    ];

    public function settings() {
        return $this->belongsTo(Setting::class);
    }

}
