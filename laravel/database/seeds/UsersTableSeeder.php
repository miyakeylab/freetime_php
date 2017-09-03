<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');
        for($n = 0;$n < 20;$n++)
        {

            App\User::create(['name' => $faker->userName, 
                                'email' => $faker->unique()->safeEmail, 
                                'provider' => "",
                                'provider_id' => "" ]);
        }
    }
}
