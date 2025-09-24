<?php

namespace App\Services;

use App\Models\Instructor;
use Stevebauman\Location\Facades\Location;

class InstructorService
{
    public function getAllInstructors(string $ip, string $lang = 'en')
    {
       
        $position = Location::get($ip) ?? (object) ['countryCode' => 'US'];
        $countryCode = $position->countryCode ?? 'US';

        $instructors = Instructor::all()->map(function ($instructor) use ($lang, $countryCode) {


            $images = collect($instructor->images ?? [])->map(function($img) {
                if (isset($img['image'])) {
                    $img['image'] = asset('storage/' . $img['image']);
                }
                return $img;
            });

            return [
                'id' => $instructor->id,
                'full_name' => $lang === 'ar' ? $instructor->full_name_ar : $instructor->full_name_en,
                'specialty' => $lang === 'ar' ? $instructor->specialty_ar : $instructor->specialty_en,
                'description' => $lang === 'ar' ? $instructor->description_ar : $instructor->description_en,
                'experience' => $instructor->experience,
                'images' => $images,
                'contacts' => $instructor->contacts ?? [],
                'students_count' => 0,
            ];
        });

        return [
            'status' => 'success',
            'data' => $instructors
        ];
    }
}
