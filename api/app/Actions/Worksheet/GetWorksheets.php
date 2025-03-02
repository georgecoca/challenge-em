<?php

namespace App\Actions\Worksheet;

use App\Filters\QueryFilterPayload;
use App\Filters\WithRelations;
use App\Filters\Worksheet\SearchFilter;
use App\Filters\Worksheet\UserFilter;
use App\Models\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Pipeline;

class GetWorksheets
{
    public function index(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        Gate::authorize('viewAny', Worksheet::class);

        $query = Worksheet::query();

        // Filters
        $filters = [
            WithRelations::class,
            UserFilter::class,
            SearchFilter::class,
        ];

        $payload = new QueryFilterPayload($query, $request);

        return Pipeline::send($payload)
            ->through($filters)
            ->thenReturn()
            ->query;
    }
}
