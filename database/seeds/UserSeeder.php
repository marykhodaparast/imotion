<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Mehrdad Mirsamie",
            'email' => 'm.mirsamie@gmail.com',
            'role_id' => 1,
            'athlete_id' => 1,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Maryam Khodaparast",
            'email' => 'maryam.kh@gmail.com',
            'role_id' => 1,
            'athlete_id' => 2,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Sara Alemi",
            'email' => 'sara.alemi@gmail.com',
            'role_id' => 1,
            'athlete_id' => 3,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Sonia Salehi",
            'email' => 's.salehi@gmail.com',
            'role_id' => 1,
            'athlete_id' => 4,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Mona Khakpash",
            'email' => 'm.khakpash@gmail.com',
            'role_id' => 1,
            'athlete_id' => 5,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "admin",
            'email' => 'admin@gmail.com',
            'role_id' => 2,
            'athlete_id' => 6,
            'password' => Hash::make('123456'),
        ]);
    }
}
