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
        $subjects = Subject::orderBy('name', 'asc')
        ->orderByRaw("CASE 
                        WHEN course_level = '1r' THEN 1
                        WHEN course_level = '2n' THEN 2
                        WHEN course_level = '3r' THEN 3
                        WHEN course_level = '4t' THEN 4
                        ELSE 5 
                      END")
        ->get();
    
        return response()->json($subjects);Subject::orderBy('name', 'asc')->orderByRaw("FIELD(course_level, '1r', '2n', '4r', '4t')");
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
        
        if ($average === null) {
            return response()->json([
                'subject_name' => $subject->name,
                'subject_level' => $subject->course_level,
                'average_grade' => 'No grades available to calculate subject average.',
                'message' => 'No grades available to calculate subject average.'
            ], 404);
        }

        return response()->json([
            'subject_name' => $subject->name,
            'subject_level' => $subject->course_level,
            'average_grade' => number_format($average, 2, '.', '')
        ]);
    }

}
