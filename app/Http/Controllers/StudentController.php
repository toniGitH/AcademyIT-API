<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
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
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function update(Request $request, Student $student)
    {
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
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json([
            'message' => 'Student successfully deleted.'
        ], 200);
    }
}
