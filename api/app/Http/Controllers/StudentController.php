<?php

namespace App\Http\Controllers;

use App\Actions\User\GetUser;
use App\Actions\User\GetUsers;
use App\Http\Requests\User\IndexRequest;
use App\Http\Resources\StudentResource;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index(IndexRequest $request, GetUsers $getUsers): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = $getUsers
            ->index($request)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return StudentResource::collection($users);
    }

    public function show(Request $request, User $student, GetUser $getUser): StudentResource
    {
        $student = $getUser->get($request, $student);

        return new StudentResource($student);
    }
}
