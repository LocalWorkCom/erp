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
            ['id' => Str::uuid(),'name_ar' => 'مصر', 'name_en' => 'Egypt', 'code' => 'EG', 'currency_ar' => 'جنيه مصري', 'currency_en' => 'Egyptian Pound', 'currency_code' => 'EGP', 'phone_code' => '+20', 'length' => 11],
            ['id' => Str::uuid(),'name_ar' => 'الولايات المتحدة', 'name_en' => 'United States', 'code' => 'US', 'currency_ar' => 'دولار أمريكي', 'currency_en' => 'US Dollar', 'currency_code' => 'USD', 'phone_code' => '+1', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'فرنسا', 'name_en' => 'France', 'code' => 'FR', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'phone_code' => '+33', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'ألمانيا', 'name_en' => 'Germany', 'code' => 'DE', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'phone_code' => '+49', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'إيطاليا', 'name_en' => 'Italy', 'code' => 'IT', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'phone_code' => '+39', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'كندا', 'name_en' => 'Canada', 'code' => 'CA', 'currency_ar' => 'دولار كندي', 'currency_en' => 'Canadian Dollar', 'currency_code' => 'CAD', 'phone_code' => '+1', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'أستراليا', 'name_en' => 'Australia', 'code' => 'AU', 'currency_ar' => 'دولار أسترالي', 'currency_en' => 'Australian Dollar', 'currency_code' => 'AUD', 'phone_code' => '+61', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'اليابان', 'name_en' => 'Japan', 'code' => 'JP', 'currency_ar' => 'ين ياباني', 'currency_en' => 'Japanese Yen', 'currency_code' => 'JPY', 'phone_code' => '+81', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'الصين', 'name_en' => 'China', 'code' => 'CN', 'currency_ar' => 'يوان صيني', 'currency_en' => 'Chinese Yuan', 'currency_code' => 'CNY', 'phone_code' => '+86', 'length' => 11],
            ['id' => Str::uuid(),'name_ar' => 'السعودية', 'name_en' => 'Saudi Arabia', 'code' => 'SA', 'currency_ar' => 'ريال سعودي', 'currency_en' => 'Saudi Riyal', 'currency_code' => 'SAR', 'phone_code' => '+966', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'الإمارات', 'name_en' => 'United Arab Emirates', 'code' => 'AE', 'currency_ar' => 'درهم إماراتي', 'currency_en' => 'Emirati Dirham', 'currency_code' => 'AED', 'phone_code' => '+971', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'المملكة المتحدة', 'name_en' => 'United Kingdom', 'code' => 'GB', 'currency_ar' => 'جنيه إسترليني', 'currency_en' => 'British Pound', 'currency_code' => 'GBP', 'phone_code' => '+44', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'الهند', 'name_en' => 'India', 'code' => 'IN', 'currency_ar' => 'روبية هندية', 'currency_en' => 'Indian Rupee', 'currency_code' => 'INR', 'phone_code' => '+91', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'المكسيك', 'name_en' => 'Mexico', 'code' => 'MX', 'currency_ar' => 'بيزو مكسيكي', 'currency_en' => 'Mexican Peso', 'currency_code' => 'MXN', 'phone_code' => '+52', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'البرازيل', 'name_en' => 'Brazil', 'code' => 'BR', 'currency_ar' => 'ريال برازيلي', 'currency_en' => 'Brazilian Real', 'currency_code' => 'BRL', 'phone_code' => '+55', 'length' => 11],
            ['id' => Str::uuid(),'name_ar' => 'الأرجنتين', 'name_en' => 'Argentina', 'code' => 'AR', 'currency_ar' => 'بيزو أرجنتيني', 'currency_en' => 'Argentine Peso', 'currency_code' => 'ARS', 'phone_code' => '+54', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'جنوب أفريقيا', 'name_en' => 'South Africa', 'code' => 'ZA', 'currency_ar' => 'راند جنوب أفريقي', 'currency_en' => 'South African Rand', 'currency_code' => 'ZAR', 'phone_code' => '+27', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'روسيا', 'name_en' => 'Russia', 'code' => 'RU', 'currency_ar' => 'روبل روسي', 'currency_en' => 'Russian Ruble', 'currency_code' => 'RUB', 'phone_code' => '+7', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'كوريا الجنوبية', 'name_en' => 'South Korea', 'code' => 'KR', 'currency_ar' => 'وون كوري', 'currency_en' => 'South Korean Won', 'currency_code' => 'KRW', 'phone_code' => '+82', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'تركيا', 'name_en' => 'Turkey', 'code' => 'TR', 'currency_ar' => 'ليرة تركية', 'currency_en' => 'Turkish Lira', 'currency_code' => 'TRY', 'phone_code' => '+90', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'إسبانيا', 'name_en' => 'Spain', 'code' => 'ES', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'phone_code' => '+34', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'السويد', 'name_en' => 'Sweden', 'code' => 'SE', 'currency_ar' => 'كرونة سويدية', 'currency_en' => 'Swedish Krona', 'currency_code' => 'SEK', 'phone_code' => '+46', 'length' => 10],
            ['id' => Str::uuid(),'name_ar' => 'النرويج', 'name_en' => 'Norway', 'code' => 'NO', 'currency_ar' => 'كرونة نرويجية', 'currency_en' => 'Norwegian Krone', 'currency_code' => 'NOK', 'phone_code' => '+47', 'length' => 8],
            ['id' => Str::uuid(),'name_ar' => 'فنلندا', 'name_en' => 'Finland', 'code' => 'FI', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'phone_code' => '+358', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'سويسرا', 'name_en' => 'Switzerland', 'code' => 'CH', 'currency_ar' => 'فرنك سويسري', 'currency_en' => 'Swiss Franc', 'currency_code' => 'CHF', 'phone_code' => '+41', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'هولندا', 'name_en' => 'Netherlands', 'code' => 'NL', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'phone_code' => '+31', 'length' => 9],
            ['id' => Str::uuid(),'name_ar' => 'بلجيكا', 'name_en' => 'Belgium', 'code' => 'BE', 'currency_ar' => 'يورو', 'currency_en' => 'Euro', 'currency_code' => 'EUR', 'phone_code' => '+32', 'length' => 9],
        ];


        DB::table('countries')->insert($countries);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
