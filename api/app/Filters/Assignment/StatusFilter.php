<?php

namespace App\Filters\Assignment;

use App\Filters\QueryFilterPayload;
use Closure;

class StatusFilter
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        if ($payload->request->has('status')) {
            $status = filter_var(
                $payload->request->get('status'),
                FILTER_VALIDATE_BOOLEAN
            );

            if ($status === true) {
                $payload->query->whereNotNull('response');
            } else {
                $payload->query->whereNull('response');
            }
        }

        return $next($payload);
    }
}
