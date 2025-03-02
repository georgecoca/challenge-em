<?php

namespace App\Actions\Worksheet;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Gate;

class CreateWorksheet
{
    /**
     * @throws \Exception
     */
    public function create(User $user, array $data): Worksheet
    {
        Gate::authorize('create', Worksheet::class);

        return $user->worksheets()->create([
            'name' => $data['name'],
            'type' => Worksheet::TYPE_WORD_MATCH,
            'schema' => $data['questions'],
        ]);
    }
}
