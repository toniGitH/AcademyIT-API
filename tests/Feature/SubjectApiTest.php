<?php

namespace Tests\Feature;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_subjects()
    {
        Subject::factory()->count(3)->create();

        $response = $this->getJson('/api/subjects');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_create_subject()
    {
        $data = [
            'name' => 'Mathematics',
            'course_level' => '1r',
        ];

        $response = $this->postJson('/api/subjects', $data);

        $response->assertStatus(201)->assertJsonFragment(['name' => 'Mathematics']);
    }

    public function test_cannot_create_duplicate_subject()
    {
        Subject::factory()->create([
            'name' => 'Physics',
            'course_level' => '2n',
        ]);

        $response = $this->postJson('/api/subjects', [
            'name' => 'Physics',
            'course_level' => '2n',
        ]);

        $response->assertStatus(400)->assertJsonFragment(['error' => 'The subject already exists with the same course level.']);
    }

    public function test_can_show_subject()
    {
        $subject = Subject::factory()->create();

        $response = $this->getJson("/api/subjects/{$subject->id}");

        $response->assertStatus(200)->assertJsonFragment(['name' => $subject->name]);
    }

    public function test_can_update_subject()
    {
        $subject = Subject::factory()->create();

        $data = ['name' => 'Updated Name', 'course_level' => $subject->course_level];

        $response = $this->putJson("/api/subjects/{$subject->id}", $data);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_can_delete_subject()
    {
        $subject = Subject::factory()->create();

        $response = $this->deleteJson("/api/subjects/{$subject->id}");

        $response->assertStatus(200)->assertJsonFragment(['message' => 'Subject successfully deleted.']);
        $this->assertDatabaseMissing('subjects', ['id' => $subject->id]);
    }

    public function test_it_returns_404_when_no_grades_for_subject()
    {
        $subject = Subject::factory()->create();
        
        $response = $this->getJson("api/averageBySubject/{$subject->id}");
        
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'No grades available to calculate subject average.'
        ]);
    }

    public function test_it_returns_average_grade_for_subject()
    {
        $subject = Subject::factory()->create();
        
        $student1 = Student::factory()->create();
        Grade::factory()->create([
            'student_id' => $student1->id,
            'subject_id' => $subject->id,
            'grade' => 8,
        ]);

        $student2 = Student::factory()->create();
        Grade::factory()->create([
            'student_id' => $student2->id,
            'subject_id' => $subject->id,
            'grade' => 7,
        ]);

        $response = $this->getJson("api/averageBySubject/{$subject->id}");
        
        $response->assertStatus(200);
        $response->assertJson([
            'average_grade' => '7.50',
        ]);
    }

    public function test_it_returns_zero_when_only_zero_grades_for_subject()
    {
        $subject = Subject::factory()->create();
        
        $student1 = Student::factory()->create();
        Grade::factory()->create([
            'student_id' => $student1->id,
            'subject_id' => $subject->id,
            'grade' => 0,
        ]);

        $response = $this->getJson("api/averageBySubject/{$subject->id}");
        
        $response->assertStatus(200);
        $response->assertJson([
            'average_grade' => '0.00',
        ]);
    }

}
