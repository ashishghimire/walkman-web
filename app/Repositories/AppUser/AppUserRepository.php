<?php

namespace App\Repositories\AppUser;

use App\AppUser;
use Illuminate\Support\Facades\Hash;

/**
 * Class AppUserRepository
 * @package App\Repositories\AppUser
 */
class AppUserRepository implements AppUserRepositoryInterface
{

    /**
     * @var AppUser
     */
    protected $appUser;

    /**
     * AppUserRepository constructor.
     * @param AppUser $appUser
     */
    public function __construct(AppUser $appUser)
    {
        $this->appUser = $appUser;
    }

    /**
     * @param $input
     * @return bool|string
     */
    public function save($input)
    {
        $apiToken = str_random(60);
        $input['api_token'] = Hash::make($apiToken);

        if ($this->appUser->create($input)) {
            return $apiToken;
        }

        return false;
    }

    /**
     * @param $fbId
     * @return mixed
     */
    public function getByFbId($fbId)
    {
        return $this->appUser->where('fb_id', $fbId)->firstOrFail();
    }

    /**
     * @param $fbId
     * @param $data
     * @return bool
     */
    public function update($fbId, $data)
    {
        try {
            $user = $this->getByFbId($fbId);
        } catch (\Exception $e) {
            return false;
        }

        $user->total_distance_walking += $data['todays_distance_walking'];
        $user->total_distance_cycling += $data['todays_distance_cycling'];
        $user->todays_distance_walking += $data['todays_distance_walking'];
        $user->todays_distance_cycling += $data['todays_distance_cycling'];
        $user->golds = $data['golds'];
        $user->personal_best_walking = max($user->personal_best_walking, $user->todays_distance_walking);
        $user->personal_best_cycling = max($user->personal_best_cycling, $user->todays_distance_cycling);

        if ($user->save()) {
            return true;
        }

        return false;
    }


    /**
     * @param $type
     * @param int $limit
     * @return mixed
     */
    public function topContributors($type, $limit = 10)
    {
        $totalDistance = "total_distance_{$type}";
        $todaysDistance = "todays_distance_{$type}";

        return $this->appUser
            ->orderBy($todaysDistance, $totalDistance, 'desc')
            ->limit($limit)
            ->get(['fb_info', "{$todaysDistance} as todays_distance", "{$totalDistance} as total_distance", 'golds']);

    }
}