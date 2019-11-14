<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'material_style', 'color_theme_id', 'layout_style',
        'fixed_navbar', 'fixed_footer', 'reversed', 'navbar_background',
        'sidenav_background', 'footer_background', 'rtl_direction', 'user_id',
        'sidenav_color_id', 'navbar_color_id', 'footer_color_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->hasOne(ColorTheme::class);
    }

    public function navbarColor()
    {
        if (auth()->check()) {
            $color = NavbarColor::find(auth()->user()->setting->navbar_color_id);
            return 'bg-' . $color->value;
        } else {
            return 'bg-white';
        }
    }

    public function sidenavColor()
    {
        if (auth()->check()) {
            $color = SidenavColor::find(auth()->user()->setting->sidenav_color_id);
            return 'bg-' . $color->value;
        } else {
            return 'bg-dark';
        }
    }

    public function footerColor()
    {
        if (auth()->check()) {
            $color = FooterColor::find(auth()->user()->setting->footer_color_id);
            return 'bg-' . $color->value;
        } else {
            return 'bg-white';
        }
    }
}
