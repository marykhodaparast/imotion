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
            'email' => '09159879890',
            'role_id' => 1,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Maryam Khodaparast",
            'email' => '09189098765',
            'role_id' => 1,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Sara Alemi",
            'email' => '09223478909',
            'role_id' => 1,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Sonia Salehi",
            'email' => '09124356789',
            'role_id' => 1,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "Mona Khakpash",
            'email' => '09134567632',
            'role_id' => 1,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'name' => "admin",
            'email' => '09184567632',
            'role_id' => 2,
            'password' => Hash::make('123456'),
        ]);
    }
}
