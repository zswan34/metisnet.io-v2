<?php

use Illuminate\Database\Seeder;

class UserAuthTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authTypes = [
            'email_password',
            'ldap',
            '2fa_sms',
            'otp',
            'x509'
        ];

        foreach($authTypes as $type) {
            \App\UserAuthType::create(['name' => $type]);
        }
    }
}
