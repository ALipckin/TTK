<?php

namespace App\Policies;

use App\Models\Ttk;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TTKPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Ttk $ttk): Response
    {
        return $user->id === $ttk->user_id
            ? Response::allow()
            : Response::deny('You do not own this ttk.');
    }

}
