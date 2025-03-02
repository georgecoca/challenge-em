<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;

class GetStats
{
    public function handle(Request $request): array
    {
        if ($request->user()->role === User::ROLE_TEACHER) {
            return $this->teacher($request);
        }

        if ($request->user()->role === User::ROLE_STUDENT) {
            return $this->student($request);
        }

        return [];
    }

    private function teacher(Request $request): array
    {
        return [
            'worksheets_created' => $request->user()->worksheets->count(),
            'worksheets_completed' => $request->user()->teacherAssignments()->whereNotNull('response')->count(),
        ];
    }

    private function student(Request $request)
    {
        return [
            'worksheets_completed' => $request->user()->assignments()->completed()->count(),
            'worksheets_pending' => $request->user()->assignments()->pending()->count(),
        ];
    }
}
