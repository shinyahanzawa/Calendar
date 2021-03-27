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
            $table->string('user_id')->comment("ユーザーID");
            $table->string('schedule_id')->comment("スケジュールID");
            $table->dateTime('date')->comment("日付");
            $table->integer('schedule_flag')->nullable()->default(0)->comment("0:その他　1:学校　２:仕事");
            $table->string('title')->nullable();
            $table->string('body',500)->nullable();
            $table->string('address')->nullable();
            $table->integer('people')->nullable();
            $table->integer('delete_flag')->nullable()->default(0)->comment("0:有効　1:無効");
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
