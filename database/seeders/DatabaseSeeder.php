<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // CountriesTableSeeder::class,
            // UsersTableSeeder::class,
            // CategoriesTableSeeder::class,
            // SizesTableSeeder::class,
            // PointSystemsTableSeeder::class,
            // LeaveTypesTableSeeder::class,
            // APICodeTableSeeder::class,
            // You can call additional seeders here
            // AnotherSeeder::class,
        ]);
    }
}
