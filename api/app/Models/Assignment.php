<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentFactory> */
    use HasFactory;

    protected $fillable = ['worksheet_id', 'user_id', 'response', 'response_time', 'score'];

    protected $casts = [
        'response' => 'array',
    ];

    /**
     * Worksheet
     */
    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(Worksheet::class);
    }

    /**
     * Student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to only include completed assignments.
     *
     * A completed assignment is one where the response is not empty.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('response');
    }

    /**
     * Scope a query to only include pending assignments.
     *
     * A pending assignment is one where the response is empty.
     */
    public function scopePending($query)
    {
        return $query->whereNull('response');
    }
}
