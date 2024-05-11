<?php

namespace App\Policies\Admin;

use App\Models\User;

class ClientPolicy
{

    public function view(User $user, User $client): bool
    {
        return $user->isAdmin();
    }
    public function update(User $user, User $client): bool
    {
        return $user->isAdmin() && $client->isClient();
    }
}
