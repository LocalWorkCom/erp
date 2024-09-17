<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValidateApiCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            // Clothes Sizes (category_id = 1)
            ['code' => '3', 'api_code_title_en' => 'Attention', 'api_code_title_ar' => 'انتبه', 'api_code_message_en' => 'The new password cannot be the same as the current password', 'api_code_message_ar' => 'لا يمكن أن تكون كلمة المرور الجديدة هي نفس كلمة المرور الحالية'],
            ['code' => '4', 'api_code_title_en' => 'Success', 'api_code_title_ar' => 'تم بنجاح', 'api_code_message_en' =>  "User logged out", 'api_code_message_ar' => 'تم تسجيل الخروج بنجاح'],
            ['code' => '5', 'api_code_title_en' => 'Failed', 'api_code_title_ar' => 'حدث خطأ', 'api_code_message_en' =>  "Cann't delete this , because there is fildes connected with", 'api_code_message_ar' => 'لا يمكن حذف هذا العنصر لأرتباطه بعناصر أخرى '],

        ];

        DB::table('apicodes')->insert($messages);
    }
}
