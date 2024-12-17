<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LeaveTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leave_types = [
            ['id' => Str::uuid(),'name_ar' => 'اجازات رسمية', 'name_en' => 'Official leaves', 'created_by' =>1, 'created_at' => now()],
            ['id' => Str::uuid(),'name_ar' => 'اجازات طارئة', 'name_en' => 'Emergency leaves', 'created_by' =>1, 'created_at' => now()],
            ['id' => Str::uuid(),'name_ar' => 'اجازات اعتيادية', 'name_en' => 'Ordinary leaves', 'created_by' =>1, 'created_at' => now()],
            ['id' => Str::uuid(),'name_ar' => 'اجازات سنوية', 'name_en' => 'Annual leaves', 'created_by' =>1, 'created_at' => now()],
        ];

        DB::table('leave_types')->insert($leave_types);
    }
}
