<?php

namespace App\Actions\Assignment;

use App\Filters\Assignment\SearchFilter;
use App\Filters\Assignment\StatusFilter;
use App\Filters\WithRelations;
use App\Models\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Pipeline;
use App\Models\Assignment;
use App\Filters\Assignment\StudentFilter;
use App\Filters\QueryFilterPayload;

class GetAssignments
{
    public function index(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        Gate::authorize('viewAny', Assignment::class);

        $query = Assignment::query();

        // Filters
        $filters = [
            StudentFilter::class,
            WithRelations::class,
            SearchFilter::class,
            StatusFilter::class,
        ];

        $payload = new QueryFilterPayload($query, $request);

        return Pipeline::send($payload)
            ->through($filters)
            ->thenReturn()
            ->query;
    }
}
