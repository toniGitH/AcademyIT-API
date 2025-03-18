<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_students()
    {
        Student::factory()->count(3)->create();
        
        $response = $this->getJson('/api/students');
        
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_create_student()
    {
        $data = [
            'first_name' => 'John',
            'last_name_1' => 'Doe',
            'last_name_2' => 'Smith',
            'age' => 20,
        ];

        $response = $this->postJson('/api/students', $data);
        
        $response->assertStatus(201)->assertJson(['message' => 'Student successfully created.']);
        $this->assertDatabaseHas('students', $data);
    }

    public function test_can_show_student()
    {
        $student = Student::factory()->create();
        
        $response = $this->getJson("/api/students/{$student->id}");
        
        $response->assertStatus(200)->assertJson($student->toArray());
    }

    public function test_can_update_student()
    {
        $student = Student::factory()->create();
        
        $updatedData = ['first_name' => 'Jane'];
        
        $response = $this->putJson("/api/students/{$student->id}", $updatedData);
        
        $response->assertStatus(200)->assertJson(['message' => 'Student successfully updated.']);
        $this->assertDatabaseHas('students', $updatedData);
    }

    public function test_can_delete_student()
    {
        $student = Student::factory()->create();
        
        $response = $this->deleteJson("/api/students/{$student->id}");
        
        $response->assertStatus(200)->assertJson(['message' => 'Student successfully deleted.']);
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_cannot_create_student_with_invalid_data()
    {
        $data = ['first_name' => '', 'age' => 'not-a-number'];
        
        $response = $this->postJson('/api/students', $data);
        
        $response->assertStatus(422)->assertJsonStructure(['error', 'details']);
    }
}
