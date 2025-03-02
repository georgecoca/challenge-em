<?php

namespace App\Actions\Worksheet;

use App\Models\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetWorksheet
{
    public function get(Request $request, Worksheet $worksheet): Worksheet
    {
        Gate::authorize('view', $worksheet);

        return $worksheet;
    }
}
