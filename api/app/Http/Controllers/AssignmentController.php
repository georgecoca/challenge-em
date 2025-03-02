<?php

namespace App\Http\Controllers;

use App\Actions\Assignment\GetAssignment;
use App\Actions\Assignment\GetAssignments;
use App\Actions\Assignment\UpdateAssignment;
use App\Actions\Worksheet\AssignWorksheet;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GetAssignments $getAssignments)
    {
        $assignments = $getAssignments
            ->index($request)
            ->paginate();

        return AssignmentResource::collection($assignments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(Request $request, Assignment $assignment, GetAssignment $getAssignment)
    {
        $assignment = $getAssignment->get($request, $assignment);

        return new AssignmentResource($assignment);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request, AssignWorksheet $assignWorksheet)
    {
        $assignWorksheet->assign($request->user(), $request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment, UpdateAssignment $updateAssignment)
    {
        $assignment = $updateAssignment->update($request, $assignment);

        return new AssignmentResource($assignment);
    }
}
