<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    use HasFactory;

    const TYPE_WORD_MATCH = 'word_match';

    protected $fillable = ['name', 'type', 'schema'];

    protected $casts = [
      'schema' => 'array',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (Worksheet $worksheet) {
            $worksheet->assignments()->delete();
        });
    }

    /**
     * Teacher
     */
    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Assigned students
     */
    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'assignments', 'worksheet_id', 'user_id');
    }

    /**
     * Worksheet assignments
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
