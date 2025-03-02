<?php

namespace Tests\Feature\Http\Controllers;

use App\Actions\Worksheet\AssignWorksheet;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatsControllerTest extends TestCase
{
    public function test_not_authenticated(): void
    {
        $response = $this->getJson('/api/teacher/stats');

        $response->assertStatus(401);
    }

    public function test_stats_as_teacher_success(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/teacher/stats');

        $response->assertStatus(200);
    }

    public function test_stats_as_teacher_fails(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/student/stats');

        $response->assertStatus(403);
    }

    public function test_stats_as_student_success(): void
    {
        $teacher = User::factory()->student()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/student/stats');

        $response->assertStatus(200);
    }

    public function test_stats_as_student_fails(): void
    {
        $teacher = User::factory()->student()->create();

        $this->actingAs($teacher);

        $response = $this->getJson('/api/teacher/stats');

        $response->assertStatus(403);
    }
}
