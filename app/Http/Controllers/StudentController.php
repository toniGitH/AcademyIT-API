<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name_1' => 'required|string|max:255',
                'last_name_2' => 'nullable|string|max:255',
                'age' => 'required|integer|min:1',
            ]);

            $student = Student::create($validated);

            return response()->json([
                'student' => $student,
                'message' => 'Student successfully created.'
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

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'sometimes|string|max:255',
                'last_name_1' => 'sometimes|string|max:255',
                'last_name_2' => 'nullable|string|max:255',
                'age' => 'sometimes|integer|min:1',
            ]);

            $student->update($validated);

            return response()->json([
                'student' => $student,
                'message' => 'Student successfully updated.'
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

    public function destroy(Student $student)
    {
        try {
            $student->delete();

            return response()->json([
                'message' => 'Student successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred while deleting the student.'
            ], 500);
        }
    }
}
