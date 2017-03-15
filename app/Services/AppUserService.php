<?php

namespace App\Services;

use App\Repositories\AppUser\AppUserRepositoryInterface;

/**
 * Class AppUserService
 * @package App\Services
 */
class AppUserService
{
    /**
     * @var AppUserRepositoryInterface
     */
    protected $appUser;

    /**
     * AppUserService constructor.
     * @param AppUserRepositoryInterface $appUser
     */
    public function __construct(AppUserRepositoryInterface $appUser)
    {
        $this->appUser = $appUser;
    }

    /**
     * @param $data
     * @return array|bool
     */
    public function save($data)
    {
        $fbFields = json_decode($data);

        if (empty($fbFields)) {
            return false;
        }

        $existingUser = $this->userExists($fbFields->id);

        if($existingUser) {
            return [
                'message' => 'User Already Exists!!',
                'api_token' => $existingUser->api_token
            ];
        }

        $input = [];
        $input['fb_id'] = $fbFields->id;
        $input['fb_info'] = $fbFields;

        return $this->appUser->save($input);
    }

    /**
     * @param $fbId
     * @return bool
     */
    public function getByFbId($fbId)
    {
        try {
            $user = $this->appUser->getByFbId($fbId);
        } catch (\Exception $e) {
            return false;
        }
        return $user;
    }

    /**
     * @param $fbId
     * @param $apiToken
     * @return bool
     */
    public function verify($fbId, $apiToken)
    {
        if (!is_numeric($fbId)) {
            return false;
        }

        $user = $this->getByFbId($fbId);

        if (!$user) {
            return false;
        }

        return $apiToken === $user->api_token;
    }

    /**
     * @param $fbId
     * @param $data
     * @return mixed
     */
    public function update($fbId, $data)
    {
        return $this->appUser->update($fbId, $data);
    }

    /**
     * @return array
     */
    public function topWalkers()
    {
        return $this->transformCollection($this->appUser->topContributors('walking')->all());
    }

    /**
     * @return array
     */
    public function topBikers()
    {
        return $this->transformCollection($this->appUser->topContributors('cycling')->all());
    }

    public function fbFriendsTopWalkers($fbIdArray)
    {
        return $this->transformCollection($this->appUser->topContributors('walking', 10, $fbIdArray)->all());
    }

    public function fbFriendsTopBikers($fbIdArray)
    {
        return $this->transformCollection($this->appUser->topContributors('walking', 10, $fbIdArray)->all());
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
            'name' => $item['fb_info']['name'],
            'todays_distance' => $item['todays_distance'],
            'total_distance' => $item['total_distance'],
            'golds' => $item['golds'],
        ];
    }

    protected function userExists($id)
    {
        return $this->getByFbId($id);

//        if(!$user) {
//            return false;
//        }
    }
}
