<?php

namespace Tests\Feature;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_all_grades()
    {
        Grade::factory(3)->create();

        $response = $this->getJson('/api/grades');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_it_can_store_a_grade()
    {
        $student = Student::factory()->create();
        $subject = Subject::factory()->create();

        $data = [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => 9
        ];

        $response = $this->postJson('/api/grades', $data);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Grade successfully created.']);
        $this->assertDatabaseHas('grades', $data);
    }

    public function test_it_cannot_store_a_grade_for_an_existing_student_in_the_same_subject()
    {
        $student = Student::factory()->create();
        $subject = Subject::factory()->create();
        
        Grade::create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => 8
        ]);

        $data = [
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => 9
        ];

        $response = $this->postJson('/api/grades', $data);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'The student already has a grade for this subject.']);
    }

    public function test_it_can_show_a_grade()
    {
        $grade = Grade::factory()->create();

        $response = $this->getJson('/api/grades/' . $grade->id);

        $response->assertStatus(200);
        $response->assertJson(['id' => $grade->id]);
    }

    public function test_it_can_update_a_grade()
    {
        $student1 = Student::factory()->create();
        $subject1 = Subject::factory()->create();

        $student2 = Student::factory()->create();
        $subject2 = Subject::factory()->create();

        $grade = Grade::create([
            'student_id' => $student1->id,
            'subject_id' => $subject1->id,
            'grade' => 7.5
        ]);

        $data = [
            'student_id' => $student2->id,
            'subject_id' => $subject2->id,
            'grade' => 9.0
        ];

        $response = $this->putJson('/api/grades/' . $grade->id, $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Grade successfully updated.']);
        $this->assertDatabaseHas('grades', [
            'id' => $grade->id,
            'student_id' => $student2->id,
            'subject_id' => $subject2->id,
            'grade' => 9.0
        ]);
    }

    public function test_it_can_update_to_an_existing_grade_for_the_same_student_and_subject()
    {
        $student = \App\Models\Student::factory()->create();
        $subject = \App\Models\Subject::factory()->create();
        
        $existingGrade = Grade::factory()->create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => 7,
        ]);
        
        $response = $this->putJson('/api/grades/' . $existingGrade->id, [
            'grade' => 7, // La misma calificación
        ]);
        
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Grade successfully updated.',
        ]);
        
        $this->assertDatabaseHas('grades', [
            'id' => $existingGrade->id,
            'grade' => 7,
        ]);
    }
    
    public function test_it_can_update_to_a_different_grade_for_the_same_student_and_subject()
    {
        $student = \App\Models\Student::factory()->create();
        $subject = \App\Models\Subject::factory()->create();
        
        $existingGrade = Grade::factory()->create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'grade' => 7,
        ]);
        
        $response = $this->putJson('/api/grades/' . $existingGrade->id, [
            'grade' => 8,
        ]);
        
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Grade successfully updated.',
        ]);
        
        $this->assertDatabaseHas('grades', [
            'id' => $existingGrade->id,
            'grade' => 8,
        ]);
    }
    
    public function test_it_can_delete_a_grade()
    {
        $grade = Grade::factory()->create();

        $response = $this->deleteJson('/api/grades/' . $grade->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Grade successfully deleted.']);
        $this->assertDatabaseMissing('grades', ['id' => $grade->id]);
    }
}
