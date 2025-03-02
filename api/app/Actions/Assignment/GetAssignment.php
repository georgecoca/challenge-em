<?php

namespace App\Actions\Assignment;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetAssignment
{
    public function get(Request $request, Assignment $assignment): Assignment
    {
        Gate::authorize('view', $assignment);

        if ($request->has('with')) {
            $assignment->load($request->get('with'));
        }

        if ($request->has('with_count')) {
            $assignment->loadCount($request->get('with_count'));
        }

       return $assignment;
    }
}
