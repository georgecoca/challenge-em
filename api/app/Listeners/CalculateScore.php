<?php

namespace App\Listeners;

use App\Events\AssignmentAnswered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateScore
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AssignmentAnswered $event): void
    {
        // Response
        $response = $event->assignment->response;

        // Get questions
        $questions = $event->assignment->worksheet->schema;

        $points = 0;

        foreach ($questions as $question) {
            if (!empty($response[$question['id']])) {
                if ($question['id'] === $response[$question['id']]) {
                    $points += 1;
                }
            }
        }

        $event->assignment->update([
            'score' => $points,
        ]);
    }
}
