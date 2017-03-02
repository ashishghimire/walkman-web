<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can change the password.
     *
     * @param User $currentUser
     * @param  \App\User $user
     * @return mixed
     */
    public function changePassword(User $currentUser, User $user)
    {
        return $this->eitherAdminOrOwner($currentUser, $user);
    }

    public function view(User $currentUser, User $user)
    {
        return $this->eitherAdminOrOwner($currentUser, $user);
    }

    protected function eitherAdminOrOwner($currentUser, $user)
    {
        if (!$currentUser->isAdmin()) {
            return $currentUser->id === $user->id;
        }

        return true;
    }
}
