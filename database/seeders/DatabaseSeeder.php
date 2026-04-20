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
    // Create multiple test users with different passwords

    // Create 10 random users (if your factory is set up correctly)
    User::factory(10)->create();

    // Seed documents
    $this->call([
        UserSeeder::class,
        DocumentSeeder::class,
    ]);
}
}
