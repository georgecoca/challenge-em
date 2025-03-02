<?php

namespace App\Actions\Worksheet;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Gate;

class AssignWorksheet
{
    /**
     * @throws \Exception
     */
    public function assign(User $user, array $data)
    {
        $worksheet = Worksheet::query()->findOrFail($data['worksheet_id']);

        Gate::authorize('create', [Assignment::class, $worksheet]);

        return $worksheet->students()->toggle([
            $data['user_id'] => [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
