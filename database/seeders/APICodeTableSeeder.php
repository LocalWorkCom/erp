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
            ['code' => '4', 'api_code_title_en' => 'Success', 'api_code_title_ar' => 'تم بنجاح', 'api_code_message_en' =>  "User logged out", 'api_code_message_ar' => 'يجب تسجيل الدخول أولا'],
            ['code' => '5', 'api_code_title_en' => 'Failed', 'api_code_title_ar' =>  'غير صحيح', 'api_code_message_en' =>  "Please , Login to access this route", 'api_code_message_ar' => 'التوكين غير صحيح'],
            ['code' => '6', 'api_code_title_en' => "Category can't delete", 'api_code_title_ar' => 'التصنيف لا يمكن حذفه', 'api_code_message_en' =>  "Category cannot be deleted as it has associated product", 'api_code_message_ar' => 'التصنيف لا يمكن حذفه لانه مرتبط بالمنتج'],
            ['code' => '7', 'api_code_title_en' => "Failed", 'api_code_title_ar' => 'حدث خطأ', 'api_code_message_en' =>  "You cannot update the opening balance because there are transactions on this product in this store after the creation date.", 'api_code_message_ar' => "لا يمكنك تعديل الرصيد الافتتاحي لأن هناك معاملات على المنتج في هذا المتجر بعد هذا التاريخ."],
            ['code' => '8', 'api_code_title_en' => "NotExist", 'api_code_title_ar' => 'لا يوجد', 'api_code_message_en' =>  "Data is not exist.", 'api_code_message_ar' => "البيانات غير موجودة"],
            ['code' => '9', 'api_code_title_en' => "AlreadyExist", 'api_code_title_ar' => 'موجود بالفعل ', 'api_code_message_en' =>  "Data is already exist.", 'api_code_message_ar' => "البيانات موجودة بالفعل"],
            ['code' => '10', 'api_code_title_en' => "NoChange", 'api_code_title_ar' => 'لا يوجد تغير', 'api_code_message_en' =>  "Data is not changed.", 'api_code_message_ar' => "لا يوجد تحديث"],
            ['code' => '11', 'api_code_title_en' => "CouponNotValid", 'api_code_title_ar' => 'قسيمة شراء غير صالحة', 'api_code_message_en' =>  "Coupon is not valid", 'api_code_message_ar' => "القسمية غير صالحة للاستخدام"]


        ];

        DB::table('apicodes')->insert($sizes);
    }
}
