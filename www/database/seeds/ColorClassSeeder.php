<?php

use Illuminate\Database\Seeder;

class ColorClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sidenavColors = [
            'sidenav-theme',
            'primary',
            'primary-dark sidenav-dark',
            'primary-darker sidenav-dark',
            'secondary',
            'secondary-dark sidenav-dark',
            'secondary-darker sidenav-dark',
            'success',
            'success-dark sidenav-dark',
            'success-darker sidenav-dark',
            'info',
            'info-dark sidenav-dark',
            'info-darker sidenav-dark',
            'warning',
            'warning-dark sidenav-light',
            'warning-darker sidenav-light',
            'danger',
            'danger-dark sidenav-dark',
            'danger-darker sidenav-dark',
            'dark',
            'white',
            'light',
            'lighter'
        ];

        $navbarColors = [
            'navbar-theme',
            'primary',
            'primary-dark navbar-dark',
            'primary-darker navbar-dark',
            'secondary',
            'secondary-dark navbar-dark',
            'secondary-darker navbar-dark',
            'success',
            'success-dark navbar-dark',
            'success-darker navbar-dark',
            'info',
            'info-dark navbar-dark',
            'info-darker navbar-dark',
            'warning',
            'warning-dark navbar-light',
            'warning-darker navbar-light',
            'danger',
            'danger-dark navbar-dark',
            'danger-darker navbar-dark',
            'dark',
            'white',
            'light',
            'lighter'
        ];

        $footerColors = [
            'footer-theme',
            'primary',
            'primary-dark footer-dark',
            'primary-darker footer-dark',
            'secondary',
            'secondary-dark footer-dark',
            'secondary-darker footer-dark',
            'success',
            'success-dark footer-dark',
            'success-darker footer-dark',
            'info',
            'info-dark footer-dark',
            'info-darker footer-dark',
            'warning',
            'warning-dark footer-light',
            'warning-darker footer-light',
            'danger',
            'danger-dark footer-dark',
            'danger-darker footer-dark',
            'dark',
            'white',
            'light',
            'lighter'
        ];

        foreach($sidenavColors as $color) {
            \App\SidenavColor::create(['value' => $color]);
        }

        foreach($navbarColors as $color) {
            \App\NavbarColor::create(['value' => $color]);
        }

        foreach($footerColors as $color) {
            \App\FooterColor::create(['value' => $color]);
        }


    }
}
