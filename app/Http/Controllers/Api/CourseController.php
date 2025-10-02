<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Models\Enrollment;
use App\Models\CourseReview;

class CourseController extends Controller
{
    protected CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        $ip = $request->ip();
        $lang = $request->header('Accept-Language');

        $courses = $this->courseService->getCourses($ip, $lang);

        return response()->json([
            'status' => 200,
            'message' => 'Courses retrieved successfully',
            'data' => $courses,
        ]);
    }

    public function show(Request $request,  $id)
    {
        $ip = $request->ip();
        $lang = $request->header('Accept-Language');

        $course = $this->courseService->getCourseById($id, $ip, $lang);

        return response()->json([
            'status' => 200,
            'message' => 'Course retrieved successfully',
            'data' => $course,
        ]);
    }
 public function rateCourse(Request $request, $courseId)
    {
        $request->validate([
            'email' => 'required|email',
            'rate' => 'required|integer|min:1|max:5',
        ]);

        $result = $this->courseService->rateCourse($request->email, $courseId, $request->rate);

        return response()->json(
            $result['review'] ?? ['message' => $result['error']],
            $result['status']
        );
    }

 public function updateCourseReview(Request $request, $reviewId)
{
    $request->validate([
        'email' => 'required|email',
        'rate' => 'required|integer|min:1|max:5',
    ]);

    $result = $this->courseService->updateReview($request->email, $reviewId, $request->rate);

    return response()->json(
        ['message' => $result['message'] ?? $result['error']],
        $result['status']
    );
}

    public function deleteCourseReview(Request $request, $reviewId)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $result = $this->courseService->deleteReview($request->email, $reviewId);

        return response()->json(
            $result['message'] ?? ['message' => $result['error']],
            $result['status']
        );
    }





}
