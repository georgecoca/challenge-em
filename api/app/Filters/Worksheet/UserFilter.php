<?php

namespace App\Filters\Worksheet;

use App\Filters\QueryFilterPayload;
use Closure;

class UserFilter
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        $payload->query->where('user_id', $payload->request->user()->id);

        return $next($payload);
    }
}
