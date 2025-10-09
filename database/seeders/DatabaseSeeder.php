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
        // User::factory(10)->create();

        //tambah function ni untuk seed database sebelum php artisan db:seed

        $this->call([
            
            UserSeeder::class,
        ]);

        User::factory(10)->create();
       
       
    }


}
