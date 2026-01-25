<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles with descriptions
        $roles = [
            [
                'name' => 'admin',
                'description' => 'System administrator with full access to all features and user management',
                'guard_name' => 'web'
            ],
            [
                'name' => 'organizer',
                'description' => 'Event organizer who can create and manage events, but has limited system access',
                'guard_name' => 'web'
            ],
            [
                'name' => 'student',
                'description' => 'Regular student user who can register for events and view announcements',
                'guard_name' => 'web'
            ]
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }

        $this->command->info('Roles seeded successfully!');
    }
}