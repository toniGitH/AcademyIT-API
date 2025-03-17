<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response()->json($subjects);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'course_level' => 'required|in:1r,2n,3r,4t',
            ]);

            $subject = Subject::create($validated);

            return response()->json([
                'subject' => $subject,
                'message' => 'Subject successfully created.'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'The subject already exists with the same course level.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.'
            ], 500);
        }
    }

    public function show(Subject $subject)
    {
        return response()->json($subject);
    }

    public function update(Request $request, Subject $subject)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'course_level' => 'required|in:1r,2n,3r,4t',
            ]);

            $subject->update($validated);

            return response()->json([
                'subject' => $subject,
                'message' => 'Subject successfully updated.'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'The subject already exists with the same course level.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.'
            ], 500);
        }
    }

    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();

            return response()->json([
                'message' => 'Subject successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred while deleting the subject.'
            ], 500);
        }
    }

    public function getAverageGradeBySubject(Subject $subject)
    {
        $average = $subject->grades()->avg('grade');
        
        return response()->json([
            'average_grade' => $average === null ? null : number_format($average, 2, '.', '')
        ]);
    }
}
