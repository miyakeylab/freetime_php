<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendoffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendoffers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('master_user_id');//フレンドーユーザーID
            $table->unsignedInteger('client_user_id');//フレンドクライアントユーザーID
            $table->unsignedInteger('state');         //オファー状況
            $table->string('content');                //メッセージ内容
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
        Schema::dropIfExists('friendoffers');
    }
}
