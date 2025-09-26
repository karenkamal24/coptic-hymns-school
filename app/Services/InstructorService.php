<?php
namespace App\Services;

use App\Models\Instructor;
use App\Traits\UserLocationTrait;

class InstructorService
{
    use UserLocationTrait;

  
    public function getAllInstructors(string $ip, ?string $lang = null)
    {
        [$countryCode, $lang] = $this->getUserSettingsByIp($ip, $lang);

        $instructors = Instructor::all()->map(function ($instructor) use ($lang) {

            $images = collect($instructor->images ?? [])
                ->map(fn($img) => isset($img['image']) ? asset('storage/' . $img['image']) : null)
                ->filter(); // إزالة العناصر الفارغة

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

        return $instructors;
    }
}
