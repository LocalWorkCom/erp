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
            ['code' => '3', 'api_code_title_en' => 'Attention', 'api_code_title_ar' => 'انتبه', 'api_code_message_en' => 'The new password cannot be the same as the current password', 'api_code_message_ar' => 'لا يمكن أن تكون كلمة المرور الجديدة هي نفس كلمة المرور الحالية'],
            ['code' => '4', 'api_code_title_en' => 'Success', 'api_code_title_ar' => 'تم بنجاح', 'api_code_message_en' =>  "User logged out", 'api_code_message_ar' => 'تم تسجيل الخروج بنجاح'],
            ['code' => '5', 'api_code_title_en' => 'Token invalid', 'api_code_title_ar' => 'خطأ توكين', 'api_code_message_en' =>  "Token is not valid", 'api_code_message_ar' => 'التوكين غير صحيح'],
            ['code' => '6', 'api_code_title_en' => 'Category can\'t delete', 'api_code_title_ar' => 'التصنيف لا يمكن حذفه', 'api_code_message_en' =>  "Category cannot be deleted as it has associated product", 'api_code_message_ar' => 'التصنيف لا يمكن حذفه لانه مرتبط بالمنتج'],


        ];

        DB::table('apicodes')->insert($sizes);
    }
}
