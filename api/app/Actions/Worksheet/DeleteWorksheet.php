<?php

namespace App\Actions\Worksheet;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Gate;

class DeleteWorksheet
{
    /**
     * @throws \Exception
     */
    public function delete(User $user, Worksheet $worksheet): bool
    {
        Gate::authorize('delete', $worksheet);

        return $worksheet->delete();
    }
}
