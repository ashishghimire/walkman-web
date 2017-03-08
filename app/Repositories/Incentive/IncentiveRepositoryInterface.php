<?php

namespace App\Repositories\Incentive;

/**
 * Interface IncentiveRepositoryInterface
 * @package App\Repositories\Incentive
 */
interface IncentiveRepositoryInterface
{

    /**
     * @param $userId
     * @param $data
     * @return mixed
     */
    public function save($userId, $data);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data);

    /**
     * @return mixed
     */
    public function getTodaysIncentives();
}