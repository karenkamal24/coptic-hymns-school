<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UserLocationTrait;

use App\Models\Enrollment;
use App\Services\EnrollmentService;

class EnrollmentController extends Controller
{
    protected $service;
    use UserLocationTrait;

    public function __construct(EnrollmentService $service)
    {
        $this->service = $service;
    }


public function enrol(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'name'      => 'required|string',
        'email'     => 'required|email',
        'phone'     => 'nullable|string',
    ]);

    $langHeader = $request->header('Accept-Language');
    $response = $this->service->createEnrollment(
        $request->all(),
        $request->ip(),
        $langHeader
    );

    return response()->json($response);
}


    public function uploadPayment(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'receipt_image' => 'required|image|max:2048',
        ]);

        $response = $this->service->uploadReceipt($request->enrollment_id, $request->file('receipt_image'));

        return response()->json($response);
    }


public function approvedCourses(Request $request, $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email.',
        ], 422);
    }

    $ip = $request->ip();
    [$countryCode, $lang] = $this->getUserSettingsByIp($ip, $request->header('Accept-Language'));
    app()->setLocale($lang);

    $enrollments = $this->service->getApprovedCoursesByEmail($email);

    $data = $this->service->formatEnrollments($enrollments, $lang)->values();

    return response()->json([
        'status' => 'success',
        'message' => $data->isEmpty() ? 'No approved courses yet.' : 'Approved courses retrieved successfully.',
        'data' => $data,
    ]);
}


}
