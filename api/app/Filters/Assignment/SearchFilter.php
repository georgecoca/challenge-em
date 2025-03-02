<?php

namespace App\Filters\Assignment;

use App\Filters\QueryFilterPayload;
use Closure;

class SearchFilter
{
    public function handle(QueryFilterPayload $payload, Closure $next)
    {
        if ($payload->request->has('search')) {
            $search = $payload->request->get('search');

            if (!empty($search)) {
                $search = $payload->request->input('search');
                $payload->query->whereHas('worksheet', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");;
                });
            }
        }

        return $next($payload);
    }
}
