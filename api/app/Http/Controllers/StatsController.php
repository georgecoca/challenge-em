<?php

namespace App\Http\Controllers;

use App\Actions\User\GetStats;
use App\Http\Resources\StatsResource;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __invoke(Request $request, GetStats $getStats)
    {
        $stats = $getStats->handle($request);

        return new StatsResource($stats);
    }
}
