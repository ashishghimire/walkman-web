<?php

namespace App\Repositories\AppUser;

use App\AppUser;

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
        $input['api_token'] = $apiToken;

        try {
            $this->appUser->create($input);
        } catch (\Exception $e) {
            return false;
        }

        return [
            'message' => 'User successfully created',
            'api_token' => $apiToken
        ];
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
     * @param array $whereIn
     * @return mixed
     */
    public function topContributors($type, $limit = 10, array $whereIn = [])
    {
        $totalDistance = "total_distance_{$type}";
        $todaysDistance = "todays_distance_{$type}";

        $builder = $this->appUser;

        if ($whereIn) {
            $builder = $builder->whereIn('fb_id', $whereIn);
        }
        return $builder
            ->orderBy($todaysDistance, $totalDistance, 'desc')
            ->limit($limit)
            ->get(['id', 'fb_info', "{$todaysDistance} as todays_distance", "{$totalDistance} as total_distance", 'golds']);
    }
}