<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@yahoo.co.jp',
            'password' => '$2y$10$sLSOQJl5J1LTRqhJkzORgeeOiP8jy91mTwonxFjjlu5KpOV7/ekA6',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
