<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable()->comment("ユーザーID");
            $table->dateTime('date')->nullable()->comment("日付");
            $table->string('title')->nullable()->comment("タイトル");
            $table->string('schedule',500)->nullable()->comment("内容");
            $table->integer('delete_flag')->nullable()->default(0)->comment("0:有効 1:無効");
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
        Schema::dropIfExists('schedules');
    }
}
