<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->insert([
            'user_id' => 1,
            'start_date' => '2021-04-05 00:00',
            'end_date' => '2021-04-05 00:00',
            'title' => 'Happy Birth Day',
            'schedule' => '斎藤さん、誕生日おめでとうございます！！',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
