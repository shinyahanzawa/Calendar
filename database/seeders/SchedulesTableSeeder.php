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
            'start_date' => '2021-05-23 00:00',
            'end_date' => '2021-05-23 00:00',
            'title' => 'Study',
            'schedule' => 'PHP/Laravel',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
