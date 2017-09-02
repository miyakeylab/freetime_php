<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');             // ユーザーID
            $table->string('user_name');             // ユーザーID
            $table->string('user_content')->nullable();      // ユーザーコメント
            $table->unsignedInteger('user_sex');            // ユーザー性別(0:無し/1:男/2:女)
            $table->string('user_img');                     // ユーザー画像(default:no_image)
            $table->datetime('user_birthday')->nullable();    // ユーザー生年月日
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
        Schema::dropIfExists('userdetails');
    }
}
