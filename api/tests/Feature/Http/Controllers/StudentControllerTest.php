<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    public function test_not_authenticated(): void
    {
        $response = $this->getJson('/api/students');

        $response->assertStatus(401);
    }

    public function test_index_students_as_teacher_success(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/students/' . $teacher->id);

        $response->assertStatus(200);
    }

    public function test_show_student_as_teacher_success(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = User::factory()->student()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/students/' . $student->id);

        $response->assertStatus(200);
    }

    public function test_show_student_as_student_fails(): void
    {
        $student1 = User::factory()->student()->create();
        $student2 = User::factory()->student()->create();

        $this->actingAs($student1);

        $response = $this->getJson('/api/students/' . $student2->id);

        $response->assertStatus(403);
    }
}
