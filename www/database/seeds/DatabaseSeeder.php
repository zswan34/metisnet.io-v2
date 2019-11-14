<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(ColorThemeSeeder::class);
        $this->call(TimezoneSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ColorClassSeeder::class);
        $this->call(UserTypeSeeder::class);
    }
}
