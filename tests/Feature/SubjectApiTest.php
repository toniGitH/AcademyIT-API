<?php

namespace Tests\Feature;

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
        $subject = Subject::factory()->create([
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
}
