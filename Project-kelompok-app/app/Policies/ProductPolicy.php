<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }
<<<<<<< HEAD
=======

    public function update(User $user): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user): bool
    {
        return $user->is_admin;
    }
>>>>>>> fc694cda65b87420d7240fc476ed441da6c2658a
}
