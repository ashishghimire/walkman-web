<?php

namespace App\Services;


use App\Repositories\Incentive\IncentiveRepositoryInterface;

/**
 * Class IncentiveService
 * @package App\Services
 */
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

    /**
     * @param $userId
     * @param $data
     * @return mixed
     */
    public function save($userId, $data)
    {
        return $this->incentive->save($userId, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->incentive->find($id);
    }

    /**
     * @param $incentiveId
     * @param $data
     * @return mixed
     */
    public function update($incentiveId, $data)
    {
        $incentive = $this->incentive->find($incentiveId);

        return $this->incentive->update($incentive, $data);
    }

    /**
     * @param $incentiveId
     * @return mixed
     */
    public function delete($incentiveId)
    {
        $incentive = $this->incentive->find($incentiveId);

        return $incentive->delete();
    }

    /**
     * @return array
     */
    public function getTodaysIncentives()
    {
        return $this->transformCollection($this->incentive->getTodaysIncentives()->all());
    }

    /**
     * @param $items
     * @return array
     */
    protected function transformCollection($items)
    {
        return array_map([$this, 'transform'], $items);
    }

    /**
     * @param $item
     * @return array
     */
    protected function transform($item)
    {
        return [
            'description' => $item['description'],
            'gold_value' => $item['gold_value'],
            'incentive_picture' => $item['photo'],
            'sponsor_name' => $item->sponsor['name'],
            'sponsor_picture' => $item->sponsor['picture'],
        ];
    }
}
