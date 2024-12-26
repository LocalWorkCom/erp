<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Temporarily disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate role and permission-related tables
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        Role::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create roles for the 'admin' guard
        $superAdminRole = Role::firstOrCreate(['name' => 'superAdmin', 'guard_name' => 'admin']);
        $localRole = Role::firstOrCreate(['name' => 'LocalWork Admin', 'guard_name' => 'admin']);


        // Assign roles to specific users
        $user1 = User::find(1);
        $user2 = User::find(9);
        // $user3 = User::find(27);
        if ($user1) {
            $user1->assignRole($superAdminRole);
        }

        if ($user2) {
            $user2->assignRole($localRole);
        }
    }
}
