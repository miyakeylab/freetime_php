<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('master_user_id');//オファーユーザーID
            $table->unsignedInteger('client_user_id');//オファークライアントユーザーID
            $table->unsignedInteger('state');         //オファー状況
            $table->unsignedInteger('my_time_id');  //時間ID
            $table->datetime('start_time');         //スケジュール開始時間
            $table->datetime('end_time');           //スケジュール終了時間
            $table->datetime('start_time_gmt');     //スケジュール開始時間(GMT)
            $table->datetime('end_time_gmt');       //スケジュール終了時間(GMT)
            $table->string('content');                //内容
            $table->unsignedInteger('category_id'); //カテゴリーID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
