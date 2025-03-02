<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorksheetControllerTest extends TestCase
{
    public function test_not_authenticated(): void
    {
        $response = $this->getJson('/api/worksheets');

        $response->assertStatus(401);
    }

    public function test_index_worksheets_as_teacher_success(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/worksheets');

        $response->assertStatus(200);
    }

    public function test_create_worksheet_as_teacher_validation_fails(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher);

        $response = $this->postJson('/api/worksheets', [
            'name' => 'Fake name',
        ]);

        $response->assertStatus(422);
    }

    public function test_create_worksheet_as_teacher__success(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher);

        $response = $this->postJson('/api/worksheets', [
            'name' => 'Fake name',
            'questions' => [
                ['id' => 'fake', 'word' => 'fake', 'definition' => 'fake'],
                ['id' => 'fake2', 'word' => 'fake2', 'definition' => 'fake2'],
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_create_worksheet_as_student_fails(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student);

        $response = $this->postJson('/api/worksheets', [
            'name' => 'Fake name',
            'questions' => [
                ['id' => 'fake', 'word' => 'fake', 'definition' => 'fake'],
            ]
        ]);

        $response->assertStatus(403);
    }

    public function test_show_worksheet_as_teacher_success(): void
    {
        $user = User::factory()->teacher()->create();
        $worksheet = Worksheet::factory()->for($user, 'teacher')->create();

        $this->actingAs($user);

        $response = $this->getJson('/api/worksheets/' . $worksheet->id);

        $response->assertStatus(200);
    }

    public function test_show_worksheet_as_students_fails(): void
    {
        $user = User::factory()->student()->create();
        $worksheet = Worksheet::factory()->for($user, 'teacher')->create();

        $this->actingAs($user);

        $response = $this->getJson('/api/worksheets/' . $worksheet->id);

        $response->assertStatus(403);
    }

    public function test_update_worksheet_as_teacher_success(): void
    {
        $user = User::factory()->teacher()->create();
        $worksheet = Worksheet::factory()->for($user, 'teacher')->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/worksheets/' . $worksheet->id, [
            'name' => 'New Name',
            'questions' => [
                ['id' => 'fake', 'word' => 'fake', 'definition' => 'fake'],
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_update_worksheet_as_student_fails(): void
    {
        $user = User::factory()->student()->create();
        $worksheet = Worksheet::factory()->for($user, 'teacher')->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/worksheets/' . $worksheet->id);

        $response->assertStatus(403);
    }

    public function test_delete_worksheet_as_teacher_success(): void
    {
        $user = User::factory()->teacher()->create();
        $worksheet = Worksheet::factory()->for($user, 'teacher')->create();

        $this->actingAs($user);

        $response = $this->deleteJson('/api/worksheets/' . $worksheet->id);

        $response->assertStatus(200);
    }
}
