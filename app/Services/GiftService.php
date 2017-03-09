<?php

namespace App\Services;

use App\Repositories\Gift\GiftRepositoryInterface;
use App\Repositories\Incentive\IncentiveRepositoryInterface;
use App\Repositories\AppUser\AppUserRepositoryInterface;

/**
 * Class GiftService
 * @package App\Services
 */
class GiftService
{
    /**
     * @var GiftRepositoryInterface
     */
    protected $gift;
    /**
     * @var IncentiveRepositoryInterface
     */
    protected $incentive;
    /**
     * @var AppUserRepositoryInterface
     */
    protected $appUser;

    /**
     * GiftService constructor.
     * @param GiftRepositoryInterface $gift
     * @param IncentiveRepositoryInterface $incentive
     * @param AppUserRepositoryInterface $appUser
     */
    public function __construct(GiftRepositoryInterface $gift, IncentiveRepositoryInterface $incentive, AppUserRepositoryInterface $appUser)
    {
        $this->gift = $gift;
        $this->incentive = $incentive;
        $this->appUser = $appUser;
    }

    /**
     * @return bool
     */
    public function distribute()
    {
        $todaysIncentives = $this->incentive->getTodaysIncentives()->pluck('id')->all();
        $topContributors = $this->appUser->topContributors('walking', count($todaysIncentives))->pluck('id')->all();

        if ((count($topContributors) < count($todaysIncentives)) || count($todaysIncentives) == 0) {
            return false;
        }

        shuffle($todaysIncentives);
        shuffle($topContributors);
        $randomDistribution = array_combine($todaysIncentives, $topContributors);

        foreach ($randomDistribution as $incentiveId => $contributorId) {
            if (!$this->gift->create($this->createInputData($incentiveId, $contributorId))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $incentiveId
     * @param $contributorId
     * @return mixed
     */
    protected function createInputData($incentiveId, $contributorId)
    {
        $data['incentive_id'] = $incentiveId;
        $data['app_user_id'] = $contributorId;
        $data['expiry_date'] = date('Y-m-d', strtotime("+3 day"));
        $data['voucher_code'] = rand(pow(10, 4), pow(10, 5) - 1); //5 digits random number

        return $data;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function resolve($id)
    {
        $gift = $this->gift->find($id);

        if (!$gift) {
            return false;
        }

        return $this->gift->resolve($gift);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->gift->find($id);
    }

    /**
     * @param $appUserId
     * @return array
     */
    public function myGifts($appUserId)
    {
        return $this->transformCollection($this->gift->findByAppUserId($appUserId)->all());
    }

    /**
     * @param $items
     * @return array
     */
    public function transformCollection($items)
    {
        return array_map([$this, 'transform'], $items);
    }

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'gift_id' => $item['id'],
            'gift_description' => $item->incentive->description,
            'sponsor_name' => $item->incentive->sponsor->name,
            'voucher_code' => $item['voucher_code'],
            'gold_value' => $item->incentive->gold_value,
            'expiry_date' => $item['expiry_date'],
        ];
    }
}