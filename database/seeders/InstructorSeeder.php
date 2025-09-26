<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        Instructor::create([
            'full_name_en' => 'Master of Hymns',
            'full_name_ar' => 'مستر الحان',
            'specialty_en' => 'Coptic Hymns Teacher',
            'specialty_ar' => 'مدرس الألحان القبطية',
            'description_en' => 'Expert in teaching Coptic hymns with years of experience.',
            'description_ar' => 'خبير في تعليم الألحان القبطية مع سنوات من الخبرة.',
            'experience' => 15,
            'contacts' => [
                'email' => 'masterhymns@example.com',
                'phone' => '+201012345678',
                'facebook'=> 'https://www.facebook.com/masterofhymns',
                'twitter'=> 'https://twitter.com/masterofhymns',
                'instagram'=> 'https://www.instagram.com/masterofhymns',
                'linkedin'=> 'https://www.linkedin.com/in/masterofhymns',
                'youtube'=> 'https://www.youtube.com/masterofhymns',
            ],
        ]);
    }
}
