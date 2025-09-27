<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnrollmentService;

class EnrollmentController extends Controller
{
    protected $service;

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

        $response = $this->service->createEnrollment($request->all(), $request->ip());

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
}
