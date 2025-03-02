<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'assignments' => $this->whenLoaded('assignments', AssignmentResource::collection($this->assignments)),
            'assignments_count' => $this->whenCounted('assignments', $this->assignments_count),
            'completed_assignments_count' => $this->whenCounted('completedAssignments', $this->completed_assignments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
