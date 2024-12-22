<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            // add admin user 1
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                //'country_id' => 1,
                'country_code' => '+20',
                'phone' => '123123123',
                'flag' => 'admin',
            ],
            // add unkwon(cashier) user 2
            [
                'name' => 'unkown',
                'email' => 'unknown@unknown.com',
                'password' => Hash::make('unknown'),
                //'country_id' => 1,
                'country_code' => '+20',
                'phone' => '123123125',
                'flag' => 'unknown',
            ],
        ];

        DB::table('users')->insert($users);
    }
}
