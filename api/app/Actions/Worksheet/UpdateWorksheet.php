<?php

namespace App\Actions\Worksheet;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Gate;

class UpdateWorksheet
{
    /**
     * @throws \Exception
     */
    public function update(User $user, Worksheet $worksheet, array $data): bool
    {
        Gate::authorize('update', $worksheet);

        return $worksheet->update([
            'name' => $data['name'],
            'schema' => $data['questions'],
        ]);
    }
}
