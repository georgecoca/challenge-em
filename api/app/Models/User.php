<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    const ROLE_TEACHER = 'teacher';
    const ROLE_STUDENT = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function isTeacher(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role === self::ROLE_TEACHER,
        );
    }

    protected function isStudent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role === self::ROLE_STUDENT,
        );
    }

    /**
     * @throws \Exception
     */
    public function worksheets(): HasMany
    {
        if ($this->role !== self::ROLE_TEACHER) {
            throw new \Exception('Only teachers have worksheets.');
        }

        return $this->hasMany(Worksheet::class);
    }

    /**
     * Students assignments
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Students completed assignments
     */
    public function completedAssignments(): HasMany
    {
        return $this->assignments()->whereNotNull('response');
    }

    public function teacherAssignments()
    {
        return $this->hasManyThrough(Assignment::class, Worksheet::class);
    }
}
