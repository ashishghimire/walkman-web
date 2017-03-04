<?php

namespace App\Services;


use App\Repositories\Incentive\IncentiveRepositoryInterface;

class IncentiveService
{
    /**
     * @var IncentiveRepositoryInterface
     */
    protected $incentive;

    /**
     * IncentiveService constructor.
     * @param IncentiveRepositoryInterface $incentive
     */
    public function __construct(IncentiveRepositoryInterface $incentive)
    {

        $this->incentive = $incentive;
    }

    public function save($userId, $data)
    {
        return $this->incentive->save($userId, $data);
    }
}