<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userTypes = [
            'employee',
            'user_internal',
            'user_external',
            'contractor'
        ];

        foreach($userTypes as $type) {
            \App\UserType::create(['name' => $type]);
        }
    }
}
