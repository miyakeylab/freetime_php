<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');                     // ユーザー名
            $table->string('email')->nullable();        // email(null許可)
            $table->string('password', 60)->nullable(); // パスワード(null許可)
            $table->string('provider');                 // SNS向けプロバイダー名
            $table->string('provider_id');              // SNS向けプロバイダーID
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
