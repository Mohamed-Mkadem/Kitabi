<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\CitiesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Category::factory(50)->create();
        // $this->call([
        //     StateSeeder::class,
        //     CitiesSeeder::class,
        //     AdminSeeder::class
        // ]);
    }
}
