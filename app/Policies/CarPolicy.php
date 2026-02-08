<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;

class CarPolicy
{
    /**
     * Determine whether the user can update the car.
     * Owner (seller) or admin can update.
     */
    public function update(User $user, Car $car): bool
    {
        return $user->id === $car->user_id || $user->hasRole(User::ROLE_ADMIN);
    }

    /**
     * Determine whether the user can delete the car.
     * Owner (seller) or admin can delete.
     */
    public function delete(User $user, Car $car): bool
    {
        return $user->id === $car->user_id || $user->hasRole(User::ROLE_ADMIN);
    }
}
