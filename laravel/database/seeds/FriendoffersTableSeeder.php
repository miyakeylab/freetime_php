<?php

use Illuminate\Database\Seeder;

class FriendoffersTableSeeder extends Seeder
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
                    App\Friendoffer::create([ 'master_user_id' => $n,       // 申請元 
                            'client_user_id' => $i,                       // 申請先
                            'state' => $faker->numberBetween(1,3),          // オファー状況
                            'content' => $faker->word(),                    // 内容
                            
                            ]);
                }
            }
        }
    }
}
