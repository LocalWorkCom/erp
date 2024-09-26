<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointSystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  $sizes = [
        // Clothes Sizes (category_id = 1)
        ['name_ar' => 'بأجمالى الفاتوره', 'name_en' => 'total of order value', 'key' => '0', 'value' =>'1', 'active' => 0,'created_by' => 1,
        'created_at' => now(),
        'updated_at' => now()],
        ['name_ar' => 'بأجمالى الفاتوره', 'name_en' => 'total of order value', 'key' => '1', 'value' =>'10', 'active' => 0,'created_by' => 1,
        'created_at' => now(),
        'updated_at' => now()],
        ['name_ar' => 'بالمنتج', 'name_en' => 'by product', 'key' => '1', 'value' =>'5', 'active' => 0,'created_by' => 1,
        'created_at' => now(),
        'updated_at' => now()],
        ['name_ar' => 'بالمنتج', 'name_en' => 'by product', 'key' => '0', 'value' =>'10', 'active' => 1,'created_by' => 1,
        'created_at' => now(),
        'updated_at' => now()],
         ];


    DB::table('point_systems')->insert($sizes);

    }
}
