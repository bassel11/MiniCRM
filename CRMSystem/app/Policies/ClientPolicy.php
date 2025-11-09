<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
   public function view(User $user, Client $client): bool
    {
        return $user->hasRole('admin')
            || $user->hasRole('manager')
            || $client->assigned_to === $user->id;
    }

    public function update(User $user, Client $client): bool
    {
        return $user->hasRole('admin')
            || $client->assigned_to === $user->id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->hasRole('admin');
    }
}
