<?php

namespace App\Filters\User;

use App\Filters\QueryFilterPayload;
use Closure;

class OnlyAssignedFilter
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        if ($payload->request->has('only_assigned')) {
            $assigned = filter_var(
                $payload->request->get('only_assigned'),
                FILTER_VALIDATE_BOOLEAN
            );

            if ($assigned === true) {
                $payload->query->whereHas('assignments', function ($query) use ($payload) {
                    $query->where('worksheet_id', $payload->request->get('worksheet_id'));
                });
            }
        }

        return $next($payload);
    }
}
