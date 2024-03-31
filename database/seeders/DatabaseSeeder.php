<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // Generate dummy data for each table
        \App\Models\Product::factory(10)->create();
        \App\Models\Order::factory(20)->create();
        \App\Models\Payment::factory(30)->create();
    }
}
