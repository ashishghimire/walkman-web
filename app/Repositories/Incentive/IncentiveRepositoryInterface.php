<?php

namespace App\Repositories\Incentive;

interface IncentiveRepositoryInterface
{

    /**
     * @param $userId
     * @param $data
     * @return mixed
     */
    public function save($userId, $data);

    public function find($id);

    public function update($id, $data);
}