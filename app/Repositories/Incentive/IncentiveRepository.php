<?php

namespace App\Repositories\Incentive;

use App\Incentive;

class IncentiveRepository implements IncentiveRepositoryInterface
{
    /**
     * @var Incentive
     */
    protected $incentive;

    /**
     * IncentiveRepository constructor.
     * @param Incentive $incentive
     */
    public function __construct(Incentive $incentive)
    {

        $this->incentive = $incentive;
    }

    /**
     * @param $userId
     * @param $data
     * @return bool
     */
    public function save($userId, $data)
    {
        $data['user_id'] = $userId;

        if ($this->incentive->create($data)) {
            return true;
        }

        return false;
    }
}