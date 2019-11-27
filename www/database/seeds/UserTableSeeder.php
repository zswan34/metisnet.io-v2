<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $count = 10;

        for($i = 0; $i < $count; $i++) {
            $user = new \App\User();
            $user->sid = $faker->userName;
            $user->name = $faker->firstName . ' ' . $faker->lastName;
            $user->email = $faker->safeEmail;
            $user->password = bcrypt('faker');
            $user->save();
        }
    }
}
