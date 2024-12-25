<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the countries table
        DB::table('countries')->truncate();

        $countries = [
            ['id' => Str::uuid(), 'name_ar' => 'الكويت', 'name_en' => 'Kuwait', 'code' => 'KW', 'currency_ar' => 'دينار كويتي', 'currency_en' => 'Kuwaiti Dinar', 'currency_code' => 'KWD', 'currency_symbol' => 'د.ك', 'phone_code' => '+965', 'length' => 8],
            ['id' => Str::uuid(), 'name_ar' => 'مصر', 'name_en' => 'Egypt', 'code' => 'EG', 'currency_ar' => 'جنيه مصري', 'currency_en' => 'Egyptian Pound', 'currency_code' => 'EGP', 'currency_symbol' => '£', 'phone_code' => '+20', 'length' => 11],
            ['id' => Str::uuid(), 'name_ar' => 'الولايات المتحدة', 'name_en' => 'United States', 'code' => 'US', 'currency_ar' => 'دولار أمريكي', 'currency_en' => 'US Dollar', 'currency_code' => 'USD', 'currency_symbol' => '$', 'phone_code' => '+1', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'فرنسا', 'name_en' => 'France', 'code' => 'FR', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'currency_symbol' => '€', 'phone_code' => '+33', 'length' => 9],
            ['id' => Str::uuid(), 'name_ar' => 'ألمانيا', 'name_en' => 'Germany', 'code' => 'DE', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'currency_symbol' => '€', 'phone_code' => '+49', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'إيطاليا', 'name_en' => 'Italy', 'code' => 'IT', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'currency_symbol' => '€', 'phone_code' => '+39', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'كندا', 'name_en' => 'Canada', 'code' => 'CA', 'currency_ar' => 'دولار كندي', 'currency_en' => 'Canadian Dollar', 'currency_code' => 'CAD', 'currency_symbol' => '$', 'phone_code' => '+1', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'أستراليا', 'name_en' => 'Australia', 'code' => 'AU', 'currency_ar' => 'دولار أسترالي', 'currency_en' => 'Australian Dollar', 'currency_code' => 'AUD', 'currency_symbol' => '$', 'phone_code' => '+61', 'length' => 9],
            ['id' => Str::uuid(), 'name_ar' => 'اليابان', 'name_en' => 'Japan', 'code' => 'JP', 'currency_ar' => 'ين ياباني', 'currency_en' => 'Japanese Yen', 'currency_code' => 'JPY', 'currency_symbol' => '¥', 'phone_code' => '+81', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'الصين', 'name_en' => 'China', 'code' => 'CN', 'currency_ar' => 'يوان صيني', 'currency_en' => 'Chinese Yuan', 'currency_code' => 'CNY', 'currency_symbol' => '¥', 'phone_code' => '+86', 'length' => 11],
            ['id' => Str::uuid(), 'name_ar' => 'السعودية', 'name_en' => 'Saudi Arabia', 'code' => 'SA', 'currency_ar' => 'ريال سعودي', 'currency_en' => 'Saudi Riyal', 'currency_code' => 'SAR', 'currency_symbol' => '﷼', 'phone_code' => '+966', 'length' => 9],
            ['id' => Str::uuid(), 'name_ar' => 'الإمارات', 'name_en' => 'United Arab Emirates', 'code' => 'AE', 'currency_ar' => 'درهم إماراتي', 'currency_en' => 'Emirati Dirham', 'currency_code' => 'AED', 'currency_symbol' => 'د.إ', 'phone_code' => '+971', 'length' => 9],
            ['id' => Str::uuid(), 'name_ar' => 'المملكة المتحدة', 'name_en' => 'United Kingdom', 'code' => 'GB', 'currency_ar' => 'جنيه إسترليني', 'currency_en' => 'British Pound', 'currency_code' => 'GBP', 'currency_symbol' => '£', 'phone_code' => '+44', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'الهند', 'name_en' => 'India', 'code' => 'IN', 'currency_ar' => 'روبية هندية', 'currency_en' => 'Indian Rupee', 'currency_code' => 'INR', 'currency_symbol' => '₹', 'phone_code' => '+91', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'المكسيك', 'name_en' => 'Mexico', 'code' => 'MX', 'currency_ar' => 'بيزو مكسيكي', 'currency_en' => 'Mexican Peso', 'currency_code' => 'MXN', 'currency_symbol' => '$', 'phone_code' => '+52', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'البرازيل', 'name_en' => 'Brazil', 'code' => 'BR', 'currency_ar' => 'ريال برازيلي', 'currency_en' => 'Brazilian Real', 'currency_code' => 'BRL', 'currency_symbol' => 'R$', 'phone_code' => '+55', 'length' => 11],
            ['id' => Str::uuid(), 'name_ar' => 'روسيا', 'name_en' => 'Russia', 'code' => 'RU', 'currency_ar' => 'روبل روسي', 'currency_en' => 'Russian Ruble', 'currency_code' => 'RUB', 'currency_symbol' => '₽', 'phone_code' => '+7', 'length' => 10],
            ['id' => Str::uuid(), 'name_ar' => 'كوريا الجنوبية', 'name_en' => 'South Korea', 'code' => 'KR', 'currency_ar' => 'وون كوري', 'currency_en' => 'South Korean Won', 'currency_code' => 'KRW', 'currency_symbol' => '₩', 'phone_code' => '+82', 'length' => 10],
        ];

        DB::table('countries')->insert($countries);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
