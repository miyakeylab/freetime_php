<?php

use Illuminate\Database\Seeder;

class GroupusersTableSeeder extends Seeder
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
            for($i = 0;$i<20;$i++)
            {

                    App\Groupuser::create([ 'user_id' => $n,  
                            'user_group_id' => $i+1,
                            ]);
            }
        }
    }
}
