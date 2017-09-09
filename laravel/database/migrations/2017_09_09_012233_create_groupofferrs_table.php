<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupofferrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupoffers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('master_user_id');  //オファー元ユーザーID
            $table->unsignedInteger('client_user_id');  //クライアントユーザーID
            $table->unsignedInteger('group_id');        //グループID
            $table->unsignedInteger('state');           //オファー状況        
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
        Schema::dropIfExists('groupoffers');
    }
}
