<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => "Joe",
            'last_name' => "Biden",
            'email' => Str::random(10).'@gmail.com',
        ]);

        DB::table('websites')->insert([
            'name' => Str::random(10),
        ]);

    }
}
