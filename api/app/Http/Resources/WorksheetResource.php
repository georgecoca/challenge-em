<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorksheetResource extends JsonResource
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
             'user_id' => $this->user_id,
             'name' => $this->name,
             'type' => $this->type,
             'schema' => $this->schema,
             'students_count' => $this->whenCounted('students', $this->students_count),
             'created_at' => $this->created_at,
             'updated_at' => $this->updated_at,
         ];
    }
}
