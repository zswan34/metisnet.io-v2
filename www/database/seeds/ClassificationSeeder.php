<?php

use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            'confidential',
            'restricted',
            'internal use',
            'public'
        ];

        foreach ($values as $value) {
            \App\Classification::create(['name' => $value]);
        }
    }
}
