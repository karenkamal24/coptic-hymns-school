<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EnrollmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/my-courses/{email}', [EnrollmentController::class, 'approvedCourses'])
    ->name('my.courses');

    // Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
