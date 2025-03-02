<?php

namespace App\Filters\User;

use App\Filters\QueryFilterPayload;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Gate;

class RoleFilter
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        $deny = true;

        if ($payload->request->user()->role === User::ROLE_TEACHER) {
            $deny = false;
            $payload->query->where('role', User::ROLE_STUDENT);
        }

        Gate::denyIf($deny, 'Yo are not allowed to search users');

        return $next($payload);
    }
}
