<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Worksheet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (User::query()->count() > 0) {
            return;
        }

        $teacher = User::factory()->teacher()->create([
            'name' => 'John Teacher',
            'email' => 'john@edumaster.test',
        ]);

        Worksheet::factory()
            ->for($teacher, 'teacher')
            ->count(30)
            ->sequence(fn($sequence) => [
                'created_at' => now()->subDays(29 - $sequence->index)
            ])
            ->create();

        User::factory()->student()->create([
            'name' => 'Jane Student',
            'email' => 'jane@edumaster.test',
        ]);

        User::factory()->student()->count(50)->create();
    }
}
