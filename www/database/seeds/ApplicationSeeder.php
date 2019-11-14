<?php

use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = [
            '2fa' => false,
            'email_verification' => false
        ];

        \App\Application::create($app);
    }
}
