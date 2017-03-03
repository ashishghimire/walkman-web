<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncentivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('user_id')->unsigned();
            $table->string('day');
            $table->boolean('available')->default(true);
            $table->integer('gold_value')->unsigned()->default(0);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
        Schema::table('incentives', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incentives');
    }
}
