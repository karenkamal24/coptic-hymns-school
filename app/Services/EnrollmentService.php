<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\PaymentMethod;
use App\Traits\UserLocationTrait;
use App\Traits\SendMailTrait;

class EnrollmentService
{
    use UserLocationTrait;
         use SendMailTrait;

public function createEnrollment(array $data, string $ip, ?string $langHeader = null): array
{
    [$countryCode, $lang] = $this->getUserSettingsByIp($ip, $langHeader);

    $existingEnrollment = Enrollment::where('course_id', $data['course_id'])
        ->where('email', $data['email'])
        ->where('status', 'pending_payment')
        ->first();

    if ($existingEnrollment) {
        $enrollment = $existingEnrollment;
    } else {
        $enrollment = Enrollment::create([
            'course_id' => $data['course_id'],
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? null,
            'status'    => 'pending_payment',
        ]);
    }

    $course = $enrollment->course;

    $courseName = $lang === 'ar' ? $course->title_ar : $course->title_en;
    $price = $countryCode === 'EG' ? $course->price_egp : $course->price_usd;

    $paymentMethod = $countryCode === 'EG'
        ? PaymentMethod::orderBy('id', 'desc')->first()
        : PaymentMethod::orderBy('id', 'asc')->first();

    return [
        'status'         => $enrollment->status,
        'enrollment_id'  => $enrollment->id,
        'course_name'    => $courseName,
        'price'          => $price,
        'payment_method' => $paymentMethod?->name,
        'account_name'   => $paymentMethod?->account_name,
        'iban'           => $paymentMethod?->iban,
        'swift'          => $paymentMethod?->swift,
        'account_number' => $paymentMethod?->account_number,
        'bank_name'      => $paymentMethod?->bank_name,
        'bank_address'   => $paymentMethod?->bank_address,
    ];
}



    public function uploadReceipt(int $enrollmentId, $file): array
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);

        $path = $file->store('receipts', 'public');

        $enrollment->update([
            'receipt_image' => $path,
            'status' => 'waiting_verification',
        ]);

        return [
            'status' => $enrollment->status,
            'enrollment_id' => $enrollment->id,
        ];
    }


    public function getApprovedCoursesByEmail(string $email)
    {
        $enrollments = Enrollment::with('course')
            ->where('email', $email)
            ->where('status', 'confirmed')
            ->get();

        return $enrollments;
    }

public function formatEnrollments($enrollments, ?string $lang = 'en')
{
    return $enrollments
        ->filter(fn($enrollment) => $enrollment->course) // التأكد من وجود course
        ->map(function ($enrollment) use ($lang) {
            $course = $enrollment->course;

            $title = $lang === 'ar' ? ($course->title_ar ?? $course->title_en) : ($course->title_en ?? $course->title_ar);
            $description = $lang === 'ar' ? ($course->description_ar ?? '') : ($course->description_en ?? '');
            $videos = $lang === 'ar' ? ($course->videos_ar ?? []) : ($course->videos_en ?? []);

            return [
                'enrollment_id' => $enrollment->id,
                'enrolled_at' => $enrollment->created_at->format('d M Y'),
                'course' => [
                    'id' => $course->id,
                    'title' => $title,
                    'description' => $description,
                    'image_url' => $course->image ? asset('storage/' . $course->image) : null,
                    'videos' => $videos,
                    'instructor' => $course->instructor,
                    'rate' => $course->rate ?? null,
                    'duration_by_week' => $course->duration_by_weak,
                    'enrollments_count' => $course->enrollments_count ?? 0,
                ],
            ];
        });
}


}
