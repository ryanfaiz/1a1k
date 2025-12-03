<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

class AnswerPolicy
{
    /**
     * Determine if the user can update the answer.
     */
    public function update(User $user, Answer $answer): bool
    {
        return $user->id === $answer->user_id;
    }

    /**
     * Determine if the user can delete the answer.
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $user->id === $answer->user_id;
    }
}
