<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Auth\Access\Response;

class AssignmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        if($user->isTeacher) {
            return true;
        }

        return $user->id === $assignment->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Worksheet $worksheet): bool
    {
        return $user->id === $worksheet->user_id && $user->isTeacher;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        // Only allowed to answer once
        if (!empty($assignment->response)) {
           return false;
        }

        return $user->id === $assignment->user_id && $user->isStudent;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        return false;
    }
}
