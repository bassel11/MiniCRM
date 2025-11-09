<?php

namespace App\Policies;

use App\Models\FollowUp;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FollowUpPolicy
{
   public function create(User $user)
    {
        return $user->hasRole('sales_rep') || $user->hasRole('admin');
    }

    public function view(User $user, FollowUp $followUp)
    {
        return $user->hasRole('admin')
            || $user->id === $followUp->user_id
            || $user->hasRole('manager');
    }
}
