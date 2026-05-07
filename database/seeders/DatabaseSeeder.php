<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed a specific user
        $this->call([
            UserSeeder::class,
        ]);

        // Create 10 users, each with 1 shop and 3 inventories
        \App\Models\User::factory()
            ->count(10)
            ->has(\App\Models\Shop::factory()->count(1))
            ->has(\App\Models\Inventory::factory()->count(3))
            ->create();
    }


}
