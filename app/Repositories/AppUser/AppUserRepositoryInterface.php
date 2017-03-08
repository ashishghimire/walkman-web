<?php

namespace App\Repositories\AppUser;


/**
 * Interface AppUserRepositoryInterface
 * @package App\Repositories\AppUser
 */
interface AppUserRepositoryInterface
{
    /**
     * Save
     * @param $input
     * @return mixed
     */
    public function save($input);

    /**
     * get app users using fb id
     * @param $fbId
     * @return mixed
     */
    public function getByFbId($fbId);

    /**
     * Update
     * @param $fbId
     * @param $data
     * @return mixed
     */
    public function update($fbId, $data);

    /**
     * get top contributors
     * @param $type
     * @param int $limit
     * @return mixed
     */
    public function topContributors($type, $limit = 10);
}