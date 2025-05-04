<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Change to a secure password
                'role' => 'super admin', // Ensure you have 'admin' role logic in your app
            ]
        );
    }
    
    $this->call(AdminUserSeeder::class);
}
