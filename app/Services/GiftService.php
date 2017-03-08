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
     *
     */
    public function distribute()
    {
        $todaysIncentives = $this->incentive->getTodaysIncentives();
//        dd($todaysIncentivesCount);
        $topWalkers = $this->appUser->topContributors('walking', count($todaysIncentives));
        dd($topWalkers);
    }
}