<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\WorksheetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Common
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('assignments', AssignmentController::class);
});

// Teacher
Route::middleware(['auth:sanctum', 'teacher'])->group(function () {
    Route::apiResource('worksheets', WorksheetController::class);
    Route::apiResource('students', StudentController::class);
    Route::get('teacher/stats', \App\Http\Controllers\StatsController::class);
});

// Student
Route::middleware(['auth:sanctum', 'student'])->group(function () {
    Route::get('student/stats', \App\Http\Controllers\StatsController::class);
});
