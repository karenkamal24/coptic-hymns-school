<?php
namespace App\Services;

use App\Models\Instructor;
use App\Traits\UserLocationTrait;
use App\Models\Course;
use App\Models\Enrollment;

class InstructorService
{
    use UserLocationTrait;


public function getAllInstructors(string $ip, ?string $lang = null)
{
    [$countryCode, $lang] = $this->getUserSettingsByIp($ip, $lang);

    $instructor = Instructor::first(); 

    $images = collect($instructor->images ?? [])
        ->map(fn($img) => isset($img['image']) ? asset('storage/' . $img['image']) : null)
        ->filter();


    $studentsCount = Enrollment::whereIn('course_id', Course::pluck('id'))
        ->where('status', 'confirmed')
        ->count();

    return [
        'id' => $instructor->id,
        'full_name' => $lang === 'ar' ? $instructor->full_name_ar : $instructor->full_name_en,
        'specialty' => $lang === 'ar' ? $instructor->specialty_ar : $instructor->specialty_en,
        'description' => $lang === 'ar' ? $instructor->description_ar : $instructor->description_en,
        'experience' => $instructor->experience,
        'images' => $images,
        'contacts' => $instructor->contacts ?? [],
        'students_count' => $studentsCount,
    ];
}



}
