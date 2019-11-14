<?php

namespace App\Http\Controllers;

use App\ColorTheme;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function direction() {
        $rtl = request('rtl');
        auth()->user()->setting->update(['rtl_direction' => $rtl]);
        auth()->user()->setting->save();

        return [
            'success' => true,
            'message' => 'Direction changed successfully'
        ];
    }

    public function material() {
        $material = request('material');
        auth()->user()->setting->update(['material_style' => $material]);
        auth()->user()->setting->save();

        $theme = ColorTheme::find(auth()->user()->setting->color_theme_id);

        $themeHref = ($material) ? $theme->href_material : $theme->href;
        $materialText = ($material) ? '-material' : '';
        $bootstrap = asset('assets/vendor/css/rtl/bootstrap'. $materialText .'.css');
        $appwork = asset('assets/vendor/css/rtl/appwork'. $materialText.'.css');
        $theme = asset('assets/vendor/css/rtl/'. $themeHref);
        $colors = asset('assets/vendor/css/rtl/colors'. $materialText.'.css');


        return [
            'success' => true,
            'message' => 'Style changed to material successfully',
            'theme' => [
                'boostrap' => $bootstrap,
                'appwork' => $appwork,
                'theme' => $theme,
                'colors' => $colors
            ]
        ];
    }

    public function navbarFixed() {
        $fixed = request('fixed');
        auth()->user()->setting->update(['fixed_navbar' => $fixed]);
        auth()->user()->setting->save();

        return [
            'success' => true,
            'message' => 'Navbar changed successfully'
        ];
    }

    public function footerFixed() {
        $fixed = request('fixed');
        auth()->user()->setting->update(['fixed_footer' => $fixed]);
        auth()->user()->setting->save();

        return [
            'success' => true,
            'message' => 'Footer changed successfully'
        ];
    }

    public function reversed() {
        $fixed = request('fixed');
        auth()->user()->setting->update(['reversed' => $fixed]);
        auth()->user()->setting->save();

        return [
            'success' => true,
            'message' => 'Reversed changed successfully'
        ];
    }

    public function layoutStyle() {
        $style = request('style');
        auth()->user()->setting->update(['layout_style' => $style]);
        auth()->user()->setting->save();

        return [
            'success' => true,
            'message' => 'Layout style changed successfully'
        ];
    }

    public function theme() {
        $name = request('theme');
        $theme = ColorTheme::where('name', $name)->first();
        auth()->user()->setting->update(['color_theme_id' => $theme->id]);
        auth()->user()->setting->save();
        $themeHref = (auth()->user()->setting->material_style) ? $theme->href_material : $theme->href;
        $materialText = (auth()->user()->setting->material_style) ? '-material' : '';
        $bootstrap = asset('assets/vendor/css/rtl/bootstrap'. $materialText .'.css');
        $appwork = asset('assets/vendor/css/rtl/appwork'. $materialText.'.css');
        $theme = asset('assets/vendor/css/rtl/'. $themeHref);
        $colors = asset('assets/vendor/css/rtl/colors'. $materialText.'.css');

        return [
            'success' => true,
            'message' => 'Theme changed successfully',
            'theme' => [
                'boostrap' => $bootstrap,
                'appwork' => $appwork,
                'theme' => $theme,
                'colors' => $colors
            ]
        ];

    }
}
