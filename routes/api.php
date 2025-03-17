<?php

use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

// STUDENTS CRUD ROUTES
Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{student}', [StudentController::class, 'show']);
Route::put('/students/{student}', [StudentController::class, 'update']);
Route::patch('/students/{student}', [StudentController::class, 'update']);
Route::delete('/students/{student}', [StudentController::class, 'destroy']);

// SUBJECTS CRUD ROUTES
Route::get('subjects', [SubjectController::class, 'index']);
Route::post('subjects', [SubjectController::class, 'store']);
Route::get('subjects/{subject}', [SubjectController::class, 'show']);
Route::put('subjects/{subject}', [SubjectController::class, 'update']);
Route::patch('subjects/{subject}', [SubjectController::class, 'update']);
Route::delete('subjects/{subject}', [SubjectController::class, 'destroy']);

// GRADES CRUD ROUTES
Route::get('grades', [GradeController::class, 'index']);
Route::post('grades', [GradeController::class, 'store']);
Route::get('grades/{grade}', [GradeController::class, 'show']);
Route::put('grades/{grade}', [GradeController::class, 'update']);
Route::patch('grades/{grade}', [GradeController::class, 'update']);
Route::delete('grades/{grade}', [GradeController::class, 'destroy']);

// GRADES LIST BY STUDENT
Route::get('/grades/student/{studentId}', [GradeController::class, 'getGradesByStudent']);

// AVERAGE GRADE BY STUDENT
Route::get('/grades/student/{studentId}/average', [GradeController::class, 'averageGradeByStudent']);

// AVERAGE OF ALL GRADES OF ALL STUDENTS
Route::get('/overallAverageGrade', [GradeController::class, 'overallAverageGrade']);

