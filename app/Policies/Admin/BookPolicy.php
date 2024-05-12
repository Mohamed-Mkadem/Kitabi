<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\Admin\Book;

class BookPolicy
{
    public function update(User $user)
    {
        return $user->isAdmin();
    }
}
