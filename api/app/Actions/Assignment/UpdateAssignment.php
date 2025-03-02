<?php

namespace App\Actions\Assignment;

use App\Events\AssignmentAnswered;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UpdateAssignment
{
    public function update(Request $request, Assignment $assignment): Assignment
    {
        Gate::authorize('update', $assignment);

       $assignment->update([
           'response' => $request->get('answers'),
       ]);

       AssignmentAnswered::dispatch($assignment);

       return $assignment;
    }
}
