<?php

namespace App\Services;

use App\Models\Instructor;

class InstructorService
{
    public function getAllInstructors(string $ip, string $lang = 'en')
    {
        $instructors = Instructor::all()->map(function ($instructor) use ($lang) {


            $images = collect($instructor->images ?? [])->map(function($img) {
                return isset($img['image']) ? asset('storage/' . $img['image']) : null;
            })->filter();

            return [
                'id' => $instructor->id,
                'full_name' => $lang === 'ar' ? $instructor->full_name_ar : $instructor->full_name_en,
                'specialty' => $lang === 'ar' ? $instructor->specialty_ar : $instructor->specialty_en,
                'description' => $lang === 'ar' ? $instructor->description_ar : $instructor->description_en,
                'experience' => $instructor->experience,
                'images' => $images, // دلوقتي مجرد array من روابط الصور
                'contacts' => $instructor->contacts ?? [],
                'students_count' => 0,
            ];
        });

        return $instructors;
    }
}
