<?php

namespace App\Policies;

use App\Gift;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class GiftPolicy
 * @package App\Policies
 */
class GiftPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Gift $gift
     * @return bool
     */
    public function resolve(User $user, Gift $gift)
    {
        return $this->eitherAdminOrOwner($user, $gift);
    }

    /**
     * @param $user
     * @param $gift
     * @return bool
     */
    protected function eitherAdminOrOwner($user, $gift)
    {
        if (!$user->isAdmin()) {
            return $user->id === $gift->incentive->sponsor->id;
        }

        return true;
    }
}
