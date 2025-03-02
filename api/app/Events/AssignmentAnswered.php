<?php

namespace App\Events;

use App\Models\Assignment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignmentAnswered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Assignment $assignment;

    /**
     * Create a new event instance.
     */
    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }
}
