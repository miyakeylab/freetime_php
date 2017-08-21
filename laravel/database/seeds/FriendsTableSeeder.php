<?php

use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');
        App\Friend::create([ 'user_id' => 2,// 文字列 
                            'friend_user_id' => 1,
                            ]);
    }
}
