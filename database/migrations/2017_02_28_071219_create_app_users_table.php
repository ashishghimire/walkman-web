<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('fb_id')->unique();
            $table->json('fb_info');
            $table->integer('golds')->default(0);
            $table->integer('total_distance')->default(0);
            $table->integer('todays_distance')->default(0);
            $table->integer('personal_best')->default(0);
            $table->string('api_token');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('app_users');
    }
}
