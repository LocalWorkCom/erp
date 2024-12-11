<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AssignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles for the 'admin' guard
        $superAdminRole = Role::firstOrCreate(['name' => 'superAdmin', 'guard_name' => 'admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'admin']);

        // Assign roles to specific users
        $user1 = User::find(1); // Assuming user ID 1 exists
        $user2 = User::find(9); // Assuming user ID 2 exists

        if ($user1) {
            $user1->assignRole($superAdminRole);
        }

        if ($user2) {
            $user2->assignRole($adminRole);
        }
    }
}
