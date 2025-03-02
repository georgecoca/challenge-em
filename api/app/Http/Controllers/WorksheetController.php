<?php

namespace App\Http\Controllers;

use App\Actions\Worksheet\CreateWorksheet;
use App\Actions\Worksheet\DeleteWorksheet;
use App\Actions\Worksheet\GetWorksheet;
use App\Actions\Worksheet\GetWorksheets;
use App\Actions\Worksheet\UpdateWorksheet;
use App\Http\Requests\Worksheet\StoreWorksheetRequest;
use App\Http\Requests\Worksheet\UpdateWorksheetRequest;
use App\Http\Resources\WorksheetResource;
use App\Models\Worksheet;
use Illuminate\Http\Request;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index(Request $request, GetWorksheets $getWorksheets): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $worksheets = $getWorksheets
            ->index($request)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return WorksheetResource::collection($worksheets);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Exception
     */
    public function store(StoreWorksheetRequest $request, CreateWorksheet $createWorksheet)
    {
        $createWorksheet->create($request->user(), $request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Worksheet $worksheet, GetWorksheet $getWorksheet): WorksheetResource
    {
        $worksheet = $getWorksheet->get($request, $worksheet);

        return new WorksheetResource($worksheet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorksheetRequest $request, Worksheet $worksheet, UpdateWorksheet $updateWorksheet)
    {
        $updateWorksheet->update($request->user(), $worksheet, $request->all());

        return new WorksheetResource($worksheet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Worksheet $worksheet, DeleteWorksheet $deleteWorksheet)
    {
        $deleteWorksheet->delete($request->user(), $worksheet);
    }
}
