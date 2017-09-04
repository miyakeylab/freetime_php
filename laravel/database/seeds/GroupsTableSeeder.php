<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
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

            App\Group::create([ 'group_name' => $faker->word(),// 文字列
                                'group_img' => "css/assets/img/user_icon/no_icon.jpg",
                                'administrator_id' => $n + 1,//管理者ID
                    ]);

        }
    }
}
