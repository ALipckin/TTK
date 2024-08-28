<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OwnerPolicy
{
    /**
     * Determine if the given post can be updated by the user.
     */
    public function checkOwner(User $user, $model): bool
    {
        if ($model->user_id == null) {
            return true;
        }
        if ($model->user_id == $user->id) {
            return true;
        }
        return false;
    }
}
