<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetUser
{
    public function get(Request $request, User $student): User
    {
        Gate::authorize('view', $student);

        if ($request->has('with')) {
            $student->load($request->get('with'));
        }

        if ($request->has('with_count')) {
            $student->loadCount($request->get('with_count'));
        }

       return $student;
    }
}
