<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Account extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                "name"      => "adha",
                "username"  => "adha",
                "password"  => password_hash("password", PASSWORD_DEFAULT)
            ],
            [
                "name"      => "raffi",
                "username"  => "raffi",
                "password"  => password_hash("password", PASSWORD_DEFAULT)
            ]
        ]);
    }
}
