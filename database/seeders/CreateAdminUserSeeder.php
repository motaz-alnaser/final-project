<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
       
        $existingUser = User::where('email', 'motaz@admin.com')->first();

        if (!$existingUser) {
            User::create([
                'name' => 'Motaz Admin',
                'email' => 'motaz@admin.com',
                'password' => Hash::make('mo@ta@z1212'), 
                'role' => 'admin', 
            ]);

            echo "Admin user created successfully!\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}