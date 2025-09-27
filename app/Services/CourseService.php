<?php
namespace App\Services;

use App\Models\Course;
use App\Traits\UserLocationTrait;
use App\Models\CourseReview;
use App\Models\Enrollment;

class CourseService
{
    use UserLocationTrait;

    public function getCourses(string $ip, ?string $lang = null)
    {
        [$countryCode, $lang] = $this->getUserSettingsByIp($ip, $lang);

        return Course::all()->map(function ($course) use ($countryCode, $lang) {
            return [
                'id' => $course->id,
                'title' => $lang === 'ar' ? $course->title_ar : $course->title_en,
                'description' => $lang === 'ar' ? $course->description_ar : $course->description_en,
                'price' => $countryCode === 'EG' ? $course->price_egp . ' EGP' : $course->price_usd . ' USD',
                'instructor' => $course->instructor,
                'image' => $course->image ? asset('storage/' . $course->image) : null,
               'enrollments_count'=>$course->enrollments_count,
                    'rate' => $course->rate ?? 0,
            ];
        });
    }

public function getCourseById(int $id, string $ip, ?string $lang = null)
{
    $course = Course::with('reviews.enrollment')->findOrFail($id);
    [$countryCode, $lang] = $this->getUserSettingsByIp($ip, $lang);

    $reviews = $course->reviews->map(function ($review) {
        return [
            'id' => $review->id,
            'email' => $review->enrollment->email,
            'rate' => $review->rate,
            'created_at' => $review->created_at->toDateTimeString(),
        ];
    });

    return [
        'id' => $course->id,
        'title' => $lang === 'ar' ? ($course->title_ar ?? 'No Arabic Title') : ($course->title_en ?? 'No English Title'),
        'description' => $lang === 'ar' ? ($course->description_ar ?? 'No Arabic description') : ($course->description_en ?? 'No English description'),
        'price' => $countryCode === 'EG' ? $course->price_egp . ' EGP' : $course->price_usd . ' USD',
        'instructor' => $course->instructor,
        'duration_by_weak' => $course->duration_by_weak,
        'image' => $course->image ? asset('storage/' . $course->image) : null,
        'enrollments_count' => $course->enrollments_count,
        'rate' => $course->rate ?? 0,
        'reviews' => $reviews,
    ];
}

    public function rateCourse(string $email, int $courseId, int $rate)
    {

        $enrollment = Enrollment::where('course_id', $courseId)
            ->where('email', $email)
            ->where('status', 'confirmed')
            ->first();

        if (!$enrollment) {
            return ['error' => 'No confirmed enrollment found', 'status' => 400];
        }


        if (CourseReview::where('enrollment_id', $enrollment->id)->exists()) {
            return ['error' => 'You have already rated this course.', 'status' => 400];
        }

        $review = CourseReview::create([
            'course_id' => $courseId,
            'enrollment_id' => $enrollment->id,
            'rate' => $rate,
        ]);


        $course = $enrollment->course;
        $course->rate = $course->reviews()->avg('rate');
        $course->save();

        return ['review' => $review, 'status' => 200];
    }

public function updateReview(string $email, int $reviewId, int $rate)
{
    $review = CourseReview::with('enrollment', 'course')->find($reviewId);

    if (!$review) {
        return ['error' => 'Review not found', 'status' => 404];
    }

    if ($review->enrollment->email !== $email) {
        return ['error' => 'You can only update your own review.', 'status' => 403];
    }

    if ($review->enrollment->status !== 'confirmed') {
        return ['error' => 'Enrollment not confirmed.', 'status' => 403];
    }

    $review->update(['rate' => $rate]);


    $course = $review->course;
    $course->rate = $course->reviews()->avg('rate');
    $course->save();

    return [
        'message' => 'Review updated successfully',
        'status' => 200
    ];
}

    public function deleteReview(string $email, int $reviewId)
    {
        $review = CourseReview::with('enrollment', 'course')->find($reviewId);

        if (!$review) {
            return ['error' => 'Review not found', 'status' => 404];
        }

        if ($review->enrollment->email !== $email) {
            return ['error' => 'You can only delete your own review.', 'status' => 403];
        }

        if ($review->enrollment->status !== 'confirmed') {
            return ['error' => 'Enrollment not confirmed.', 'status' => 403];
        }

        $course = $review->course;
        $review->delete();

        $course->rate = $course->reviews()->avg('rate') ?? 0;
        $course->save();

        return ['message' => 'Review deleted successfully', 'status' => 200];
    }


}
