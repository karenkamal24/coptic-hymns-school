<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InstructorService;

class InstructorController extends Controller
{
    protected $instructorService;

    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    public function index(Request $request)
    {
        $ip = $request->ip();
        $lang = $request->header('Accept-Language', 'en'); 

        $instructors = $this->instructorService->getAllInstructors($ip, $lang);

        return response()->json([
            'status' => 'success',
            'data' => $instructors,
        ]);
    }
}
