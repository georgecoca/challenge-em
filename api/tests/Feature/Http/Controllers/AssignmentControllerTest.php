<?php

namespace Tests\Feature\Http\Controllers;

use App\Actions\Worksheet\AssignWorksheet;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignmentControllerTest extends TestCase
{
    public function test_not_authenticated(): void
    {
        $response = $this->getJson('/api/assignments');

        $response->assertStatus(401);
    }

    public function test_index_assignments_as_teacher_success(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/assignments');

        $response->assertStatus(200);
    }

    public function test_index_assignments_as_student_success(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student);

        $response = $this->getJson('/api/assignments');

        $response->assertStatus(200);
    }

    public function test_show_assignment_as_teacher_success(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();

        $worksheet = Worksheet::factory()->for($teacher, 'teacher')->create();

        $this->actingAs($teacher);

        $action = new AssignWorksheet();
        $action->assign($teacher, [
            'worksheet_id' => $worksheet->id,
            'user_id' => $student->id,
        ]);

        $assignment = Assignment::query()
            ->where('worksheet_id', $worksheet->id)
            ->where('user_id', $student->id)
            ->firstOrFail();


        $response = $this->getJson('/api/assignments/' . $assignment->id);

        $response->assertStatus(200);
    }

    public function test_show_assignment_as_student_success(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();

        $worksheet = Worksheet::factory()->for($teacher, 'teacher')->create();

        $this->actingAs($teacher);

        $assignment = $this->createAssignment($teacher, $worksheet, $student);

        $this->actingAs($student);

        $response = $this->getJson('/api/assignments/' . $assignment->id);

        $response->assertStatus(200);
    }

    public function test_create_assignment_as_teacher_success(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();

        $worksheet = Worksheet::factory()->for($teacher, 'teacher')->create();

        $this->actingAs($teacher);

        $response = $this->postJson('/api/assignments', [
            'worksheet_id' => $worksheet->id,
            'user_id' => $student->id,
        ]);

        $response->assertStatus(200);
    }

    public function test_create_assignment_as_student_fails(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();

        $worksheet = Worksheet::factory()->for($teacher, 'teacher')->create();

        $this->actingAs($student);

        $response = $this->postJson('/api/assignments', [
            'worksheet_id' => $worksheet->id,
            'user_id' => $student->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_update_assignment_as_teacher_fails(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();

        $worksheet = Worksheet::factory()->for($teacher, 'teacher')->create();

        $this->actingAs($teacher);

        $assignment = $this->createAssignment($teacher, $worksheet, $student);

        $response = $this->putJson('/api/assignments/' . $assignment->id, [
            'worksheet_id' => $worksheet->id,
            'user_id' => $student->id,
        ]);

        $response->assertStatus(403);
    }

    private function createAssignment($teacher, $worksheet, $student)
    {
        $action = new AssignWorksheet();
        $action->assign($teacher, [
            'worksheet_id' => $worksheet->id,
            'user_id' => $student->id,
        ]);

        return Assignment::query()
            ->where('worksheet_id', $worksheet->id)
            ->where('user_id', $student->id)
            ->firstOrFail();
    }
}
