<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'مؤسسة',
            'last_name' => 'كتابي',
            'email' => 'admin@kitabi.com',
            'role' => 'admin',
            'state_id' => '1',
            'city_id' => '1',
            'address' => '18 شارع في تونس العاصمة',
            'phone' => '20000000',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);
    }
}
