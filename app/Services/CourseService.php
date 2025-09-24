<?php
namespace App\Services;

use App\Models\Course;
use Stevebauman\Location\Facades\Location;

class CourseService
{
    public function getCourses(string $ip, string $lang = 'en')
    {
        $position = Location::get($ip) ?? (object) ['countryCode' => 'US', 'currencyCode' => 'USD'];
        $countryCode = $position->countryCode ?? 'US';

        return Course::all()->map(function ($course) use ($countryCode, $lang) {
            return [
                'id' => $course->id,
                'title' => $lang === 'ar' ? $course->title_ar : $course->title_en,
                'description' => $lang === 'ar' ? $course->description_ar : $course->description_en,
                'price' => $countryCode === 'EG' ? $course->price_egp . ' EGP' : $course->price_usd . ' USD',
                'instructor' => $course->instructor,
                'image' => $course->image ? asset('storage/' . $course->image) : null,
                'students_count' => 0,
                'rate' => 0,
            ];
        });
    }

public function getCourseById(int $id, string $ip, string $lang = 'en')
{
    $course = Course::findOrFail($id);

    $position = Location::get($ip) ?? (object) ['countryCode' => 'US', 'currencyCode' => 'USD'];
    $countryCode = $position->countryCode ?? 'US';

    return [
        'id' => $course->id,
        'title' => $lang === 'ar' ? ($course->title_ar ?? 'No Arabic Title') : ($course->title_en ?? 'No English Title'),
        'description' => $lang === 'ar' ? ($course->description_ar ?? 'No Arabic description') : ($course->description_en ?? 'No Arabic description'),
        'price' => $countryCode === 'EG' ? $course->price_egp . ' EGP' : $course->price_usd . ' USD',
        'instructor' => $course->instructor,
        'duration_by_weak' => $course->duration_by_weak,
        'image' => $course->image ? asset('storage/' . $course->image) : null,
        'students_count' => 0,
        'rate' => $course->rate ?? 0,
    ];
}

}
