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

    public function find($id)
    {
        return $this->incentive->find($id);
    }

    public function update($incentiveId, $data)
    {
        $incentive = $this->incentive->find($incentiveId);

        return $this->incentive->update($incentive, $data);
    }

    public function delete($incentiveId)
    {
        $incentive = $this->incentive->find($incentiveId);

        return $incentive->delete();
    }
}