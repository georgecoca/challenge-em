<?php

namespace App\Filters;

use Closure;

class WithRelations
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        if ($payload->request->has('with_count')) {
            $payload->query->withCount($payload->request->get('with_count'));
        }

        return $next($payload);
    }
}
