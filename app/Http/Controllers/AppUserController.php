<?php

namespace App\Http\Controllers;

use App\Services\AppUserService;
use App\Services\GiftService;
use App\Services\IncentiveService;


/**
 * Class AppUserController
 * @package App\Http\Controllers
 */
class AppUserController extends ApiController
{
    /**
     * @var AppUserService
     */
    protected $appUser;
    /**
     * @var IncentiveService
     */
    protected $incentive;
    /**
     * @var GiftService
     */
    protected $gift;

    /**
     * AppUserController constructor.
     * @param AppUserService $appUserService
     * @param IncentiveService $incentive
     * @param GiftService $gift
     */
    public function __construct(AppUserService $appUserService, IncentiveService $incentive, GiftService $gift)
    {
        $this->appUser = $appUserService;
        $this->middleware('api');
        $this->middleware('app.secret');
        $this->middleware('user.token')->except('store');
        $this->incentive = $incentive;
        $this->gift = $gift;
    }

    /**
     * Store User
     * @return mixed
     */
    public function store()
    {
        $response = $this->appUser->save(request()->get('fb_access_token'));

        if (!$response) {
            return $this->respondInternalError();
        }

        return $this->respondCreated($response['message'], $response['data']);
    }


    /**
     * Submit Score
     * @return mixed
     */
    public function submitScore()
    {
        if (!(request()->has('todays_distance_walking') && request()->has('todays_distance_cycling') && request()->has('golds'))) {
            return $this->respondParameterFailed('invalid parameters');
        }

        if (!$this->appUser->update(request()->header('fb_id'), request()->all())) {
            return $this->respondInternalError();
        }

        return $this->respondUpdated('User Successfully Updated');
    }

    /**
     * Get top contributors
     * @return mixed
     */
    public function leaderBoard()
    {
        return $this->respond([
            'top_contributors_walking' => $this->appUser->topWalkers(),
            'top_contributors_cycling' => $this->appUser->topBikers(),
        ]);
    }

    /**
     * @return mixed
     */
    public function socialLeaderBoard()
    {
        if (!request()->header('fb_friends')) {
            return $this->respondParameterFailed('invalid parameters');
        }
        $fbIdArray = array_map('trim', explode(',', request()->header('fb_friends')));

        return $this->respond([
            'top_contributors_walking' => $this->appUser->fbFriendsTopWalkers($fbIdArray),
            'top_contributors_cycling' => $this->appUser->fbFriendsTopBikers($fbIdArray),
        ]);
    }

    /**
     * @return mixed
     */
    public function getTodaysIncentives()
    {
        return $this->respond([
            'todays_incentives' => $this->incentive->getTodaysIncentives(),
        ]);
    }

    /**
     * @return mixed
     */
    public function myGifts()
    {
        $appUserId = $this->appUser->getByFbId(request()->header('fb_id'))->id;

        return $this->respond([
            'my_gifts' => $this->gift->myGifts($appUserId),
        ]);
    }
}
