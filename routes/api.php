<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\SettingController;

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::get('/{id}', [CourseController::class, 'show']);
});
Route::get('instructors', [InstructorController::class, 'index']);
Route::get('get-information', [SettingController::class, 'getInformation']);
Route::get('get-setting', [SettingController::class, 'getSetting']);
