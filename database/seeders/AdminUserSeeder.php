<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('email', 'admin@spccqc.edu.ph')->exists();
        
        if (!$adminExists) {
            // Create admin user
            $admin = User::create([
                'first_name' => 'System',
                'middle_name' => 'Admin',
                'last_name' => 'Administrator',
                'email' => 'admin@spccqc.edu.ph',
                'password' => Hash::make('123456789'), // Change this password!
            ]);

            // Assign admin role
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $admin->assignRole($adminRole);
            }

            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}