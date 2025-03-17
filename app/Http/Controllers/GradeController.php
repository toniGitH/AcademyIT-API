<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'subject'])->get();
        return response()->json($grades);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'subject_id' => 'required|exists:subjects,id',
                'grade' => 'nullable|numeric|min:0|max:10',
            ]);

            $existingGrade = Grade::where('student_id', $validated['student_id'])
                ->where('subject_id', $validated['subject_id'])
                ->first();

            if ($existingGrade) {
                return response()->json([
                    'error' => 'The student already has a grade for this subject.'
                ], 400);
            }

            $grade = Grade::create($validated);

            return response()->json([
                'grade' => $grade,
                'message' => 'Grade successfully created.'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'A database error occurred.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.'
            ], 500);
        }
    }

    public function show(Grade $grade)
    {
        return response()->json($grade->load(['student', 'subject']));
    }

    public function update(Request $request, Grade $grade)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'sometimes|exists:students,id',
                'subject_id' => 'sometimes|exists:subjects,id',
                'grade' => 'nullable|numeric|min:0|max:10',
            ]);

            if (isset($validated['student_id']) && isset($validated['subject_id'])) {
                $existingGrade = Grade::where('student_id', $validated['student_id'])
                    ->where('subject_id', $validated['subject_id'])
                    ->where('id', '<>', $grade->id)
                    ->first();

                if ($existingGrade) {
                    return response()->json([
                        'error' => 'The student already has a grade for this subject.'
                    ], 400);
                }
            }

            $grade->update($validated);

            return response()->json([
                'grade' => $grade,
                'message' => 'Grade successfully updated.'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'A database error occurred.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.'
            ], 500);
        }
    }

    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();

            return response()->json([
                'message' => 'Grade successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred while deleting the grade.'
            ], 500);
        }
    }

    public function getGradesByStudent($studentId)
    {
        $grades = Grade::where('student_id', $studentId)->get();

        if ($grades->isEmpty()) {
            return response()->json([
                'message' => 'No grades found for this student.'
            ], 404);
        }

        return response()->json($grades);
    }

}