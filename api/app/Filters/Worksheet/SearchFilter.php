<?php

namespace App\Filters\Worksheet;

use App\Filters\QueryFilterPayload;
use Closure;

class SearchFilter
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        if ($payload->request->has('search')) {
            $search = $payload->request->input('search');
            $payload->query->where('name', 'LIKE', "%{$search}%");
        }

        return $next($payload);
    }
}
