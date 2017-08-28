<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dt = Carbon::now();
        $dt_gmt = $dt->subHour(9);
        $faker = Faker\Factory::create('ja_JP');
        for($n = 0;$n < 10;$n++)
        {
            for($i = 0;$i<10;$i++)
            {
                if($i !== $n)
                {
                    App\Offer::create([ 'master_user_id' => $n,             // 申請元 
                            'client_user_id' => $i+1,                       // 申請先
                            'state' => $faker->numberBetween(1,3),          // オファー状況
                            'my_time_id' => $faker->numberBetween(1,24),    // 時間ID
                            'start_time' => $dt,                            // スケジュール開始時間
                            'end_time' => $dt->addHour(5),                  // スケジュール終了時間
                            'start_time_gmt' => $dt_gmt,                    // スケジュール開始時間(GMT)
                            'end_time_gmt' => $dt_gmt->addHour(5),          // スケジュール終了時間(GMT)
                            'content' => $faker->word(),                    // 内容
                            'category_id' => $faker->numberBetween(1,9),    // カテゴリーID
                            ]);
                }
            }
        }
    }
}
