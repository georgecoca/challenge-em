<?php

namespace App\Actions\User;

use App\Filters\QueryFilterPayload;
use App\Filters\User\OnlyAssignedFilter;
use App\Filters\User\RoleFilter;
use App\Filters\User\SearchFilter;
use App\Filters\WithRelations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Pipeline;

class GetUsers
{
    public function index(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        Gate::authorize('viewAny', User::class);

        $query = User::query();

        // Filters
        $filters = [
            RoleFilter::class,
            WithRelations::class,
            SearchFilter::class,
            OnlyAssignedFilter::class,
        ];

        $payload = new QueryFilterPayload($query, $request);

        return Pipeline::send($payload)
            ->through($filters)
            ->thenReturn()
            ->query;
    }
}
