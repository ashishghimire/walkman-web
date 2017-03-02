<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSponsors()
    {
        return $this->user->getSponsors();
    }

    /**
     * @param $id
     * @return null
     */
    public function find($id)
    {
        try {
            $user = $this->user->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return $user;
    }

    /**
     * @param $user
     * @param $data
     * @return mixed
     */
    public function update($user, $data)
    {
        return $this->user->update($user, $data);
    }

    /**
     * @param $user
     * @param $data
     * @return mixed
     */
    public function changePassword($user, $data)
    {
        return $this->user->changePassword($user, $data);
    }
}
