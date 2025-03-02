<?php

namespace App\Filters\Assignment;

use App\Filters\QueryFilterPayload;
use App\Models\User;
use Closure;

class StudentFilter
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        if($payload->request->user()->role === User::ROLE_TEACHER) {
            $payload->query->where('user_id', $payload->request->get('user_id'));
        } else {
            $payload->query->where('user_id', $payload->request->user()->id);
        }

        return $next($payload);
    }
}
