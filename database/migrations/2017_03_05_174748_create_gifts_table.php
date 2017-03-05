<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_code');
            $table->integer('incentive_id')->unsigned();
            $table->integer('app_user_id')->unsigned();
            $table->date('expiry_date');
            $table->boolean('resolved')->default(false);
            $table->timestamps();
        });
        Schema::table('gifts', function ($table) {
            $table->foreign('incentive_id')->references('id')->on('incentives')->onDelete('cascade');
            $table->foreign('app_user_id')->references('id')->on('app_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
