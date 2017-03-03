<?php

namespace App\Http\Controllers;

use App\Services\AppUserService;


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
     * AppUserController constructor.
     * @param AppUserService $appUserService
     */
    public function __construct(AppUserService $appUserService)
    {
        $this->appUser = $appUserService;
        $this->middleware('user.token')->except('store');
    }

    /**
     * Store User
     * @return mixed
     */
    public function store()
    {
        $apiToken = $this->appUser->save(request()->get('fb_info'));

        if (!$apiToken) {
            return $this->respondInternalError();
        }

        return $this->respondCreated('User Successfully Created', $apiToken);
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
}
