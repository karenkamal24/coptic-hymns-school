<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\EnrollmentController;

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::get('/{id}', [CourseController::class, 'show']);
    Route::post('/enrol', [EnrollmentController::class, 'enrol']);
    Route::post('upload-payment', [EnrollmentController::class, 'uploadPayment']);
});
Route::get('instructors', [InstructorController::class, 'index']);
Route::get('get-information', [SettingController::class, 'getInformation']);
Route::get('get-setting', [SettingController::class, 'getSetting']);


Route::get('/my-courses/{email}', [EnrollmentController::class, 'approvedCourses'])->name('api.my.courses');

Route::post('/courses/{course}/rate', [CourseController::class, 'rateCourse']);
Route::put('/reviews/{review}', [CourseController::class, 'updateCourseReview']);


Route::delete('/reviews/{review}', [CourseController::class, 'deleteCourseReview']);
