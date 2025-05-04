<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Admin2',
            'password' => Hash::make('admin1232'), // Change to a secure password
            'role' => 'super admin', // Ensure you have 'admin' role logic in your app
        ]);
    }
}
