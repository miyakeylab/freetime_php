<?php

use Illuminate\Database\Seeder;

class userdetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');
        for($i = 4;$i<20;$i++)
        {
            App\Userdetail::create([ 'user_id' => $i,                       // ユーザーID
                'user_name' => $faker->userName,                       // ユーザーコメント
                'user_content' => $faker->word(),                       // ユーザーコメント
                'user_sex' => $faker->numberBetween(0, 2),              // ユーザー性別(0:無し/1:男/2:女)
                'user_img' => "css/assets/img/user_icon/no_icon.jpg",   // ユーザー画像(default:no_image)
                'user_birthday' => $faker->dateTime('now'),             // ユーザー生年月日
                'user_privacy' => 0,        // ユーザープライバシー(0:ロック/666:全表示)
                                ]);
        }
    }
}
