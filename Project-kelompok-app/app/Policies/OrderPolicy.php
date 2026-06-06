<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return ! $user->is_admin;
    }

    public function view(User $user, Order $order): bool
    {
        return ! $user->is_admin && (int) $order->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return ! $user->is_admin;
    }

    public function simulatePayment(User $user, Order $order): bool
    {
        return $this->view($user, $order);
    }
}
