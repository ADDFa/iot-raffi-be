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
                "name"      => "Dokter",
                "username"  => "doctor",
                "password"  => password_hash("my-doctor", PASSWORD_DEFAULT),
                "role"      => "doctor"
            ],
            [
                "name"      => "raffi",
                "username"  => "raffi",
                "password"  => password_hash("password", PASSWORD_DEFAULT),
                "role"      => "user"
            ],
            [
                "name"      => "adha",
                "username"  => "adha",
                "password"  => password_hash("password", PASSWORD_DEFAULT),
                "role"      => "user"
            ]
        ]);
    }
}
