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
        for($n = 0;$n < 10;$n++)
        {
            for($i = 0;$i<10;$i++)
            {
                if($i !== $n)
                {
                    App\Friend::create([ 'user_id' => $n,// 文字列 
                            'friend_user_id' => $i+1,
                            ]);
                }
            }
        }
    }
}
