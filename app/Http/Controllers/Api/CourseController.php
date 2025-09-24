<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CourseService;


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
        $lang = $request->header('Accept-Language', 'en');

        $courses = $this->courseService->getCourses($ip, $lang);

        return response()->json([
            'status' => 200,
            'message' => 'Courses retrieved successfully',
            'data' => $courses,
        ]);
    }

    public function show(Request $request, $id)
{
    $ip = $request->ip();
    $lang = $request->header('Accept-Language', 'en');

    $course = $this->courseService->getCourseById($id, $ip, $lang);

    return response()->json([
        'status' => 200,
        'message' => 'Course retrieved successfully',
        'data' => $course,
    ]);
}

}
