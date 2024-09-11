<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class APICodeTableSeeder extends Seeder
{
    public function run()
    {
        $sizes = [
            // Clothes Sizes (category_id = 1)
            ['code' => '1', 'api_code_title_en' => 'Success', 'api_code_title_ar' => 'صحيح', 'api_code_message_en' => 'Success Message', 'api_code_message_ar' => 'طلب صحيح'],
            ['code' => '2', 'api_code_title_en' => 'Failed', 'api_code_title_ar' => 'غير صحيح', 'api_code_message_en' => 'Failed Message', 'api_code_message_ar' => 'طلب غير صحيح'],

        ];

        DB::table('apicodes')->insert($sizes);
    }
}
