<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Create Permissions
        //   $modules = [
        //     'dashboard',
        //     'actionbacklogs',
        //     'advances',
        //     'advance_requests',
        //     'advance_settings',
        //     'branches',
        //     'branch_coupon',
        //     'branch_discount',
        //     'branch_recipe',
        //     'brands',
        //     'cashier_machines',
        //     'cashier_machine_logs',
        //     'categories',
        //     'client_addresses',
        //     'client_details',
        //     'colors',
        //     'countries',
        //     'coupons',
        //     'cuisines',
        //     'delays',
        //     'delay_deductions',
        //     'delay_times',
        //     'delivery_settings',
        //     'departments',
        //     'discounts',
        //     'dishes',
        //     'dish_addons',
        //     'dish_categories',
        //     'dish_details',
        //     'dish_discount',
        //     'divisions',
        //     'einvoices',
        //     'einvoice_settings',
        //     'employees',
        //     'employee_floor_partitions',
        //     'employee_opening_balances',
        //     'employee_schedules',
        //     'excuses',
        //     'excuse_requests',
        //     'excuse_settings',
        //     'floors',
        //     'floor_partitions',
        //     'gifts',
        //     'ingredients',
        //     'leave_nationals',
        //     'leave_requests',
        //     'leave_settings',
        //     'leave_types',
        //     'lines',
        //     'menu',
        //     'notifications',
        //     'offers',
        //     'offer_details',
        //     'opening_balance',
        //     'orders',
        //     'order_addons',
        //     'order_details',
        //     'order_products',
        //     'order_refunds',
        //     'order_trackings',
        //     'order_transactions',
        //     'overtime_settings',
        //     'overtime_types',
        //     'payrolls',
        //     'penalties',
        //     'penalty_deductions',
        //     'penalty_reasons',
        //     'permissions',
        //     'point_products',
        //     'point_systems',
        //     'point_transactions',
        //     'positions',
        //     'products',
        //     'product_colors',
        //     'product_images',
        //     'product_limit',
        //     'product_sizes',
        //     'product_transactions',
        //     'product_transaction_logs',
        //     'product_units',
        //     'purchase_invoices',
        //     'purchase_invoices_details',
        //     'recipes',
        //     'recipe_images',
        //     'roles',
        //     'settings',
        //     'shelves',
        //     'shifts',
        //     'shift_details',
        //     'recipes',
        //     'recipe_images',
        //     'roles',
        //     'settings',
        //     'shelves',
        //     'sizes',
        //     'stores',
        //     'store_categories',
        //     'store_transactions',
        //     'store_transaction_details',
        //     'tables',
        //     'table_reservations',
        //     'timetables',
        //     'units',
        //     'users',
        //     'user_gifts',
        //     'vendors',
        //     'logos',
        //     'sliders',

        // ];

        // $actions = ['view', 'create', 'update', 'delete'];

        // foreach ($modules as $module) {
        //     foreach ($actions as $action) {
        //         // Check if the permission already exists
        //         $permissionName = "{$action} {$module}";
        //         Permission::firstOrCreate([
        //             'name' => $permissionName,
        //             'guard_name' => 'admin',
        //         ]);
        //     }
        // }

        // Create Roles and Assign Permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'superAdmin', 'guard_name' => 'admin']);
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);


        // Create Admin Role with Specific Permissions
        $adminRole = Role::firstOrCreate(['name' => 'LocalWork Admin', 'guard_name' => 'admin']);
        $adminRole->syncPermissions($allPermissions);

    }
}
