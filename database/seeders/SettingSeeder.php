<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Color;

class SettingSeeder extends Seeder
{
    public function run(): void
    {


        Setting::create([

            'logo_en'       => 'Coptic Hymns School',
            'logo_ar'       => 'مدرسة الترانيم القبطية',
            'title_en'      => 'Welcome to Our Website',
            'title_ar'      => 'مرحباً بكم في موقعنا',
            'sub_title_en'  => 'We provide amazing services to our customers.',
            'sub_title_ar'  => 'نحن نقدم خدمات رائعة لعملائنا.',
            'color'      => "#f54a00",
        ]);
    }
}
