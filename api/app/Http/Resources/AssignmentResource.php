<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        return [
            'id' => $this->id,
            'worksheet_id' => $this->worksheet_id,
            'worksheet' => $this->whenLoaded('worksheet', new WorksheetResource($this->worksheet)),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', new StudentResource($this->user)),
            'score' => $this->score,
            'response' => $this->response,
            'response_time' => $this->response_time,
            'completed' => !empty($data['response']),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
