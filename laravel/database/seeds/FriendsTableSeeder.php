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
        for($i = 2;$i<10;$i++)
        {
            // App\Friend::create([ 'user_id' => $i,// 文字列 
            //                     'friend_user_id' => $i+1,
            //                     ]);
                        App\Friend::create([ 'user_id' => 1,// 文字列 
                                'friend_user_id' => $i+1,
                                ]);
        }
    }
}
