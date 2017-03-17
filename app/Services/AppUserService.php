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
     * @param $accessToken
     * @return array|bool
     */
    public function save($accessToken)
    {
        try {
            $data = file_get_contents("https://graph.facebook.com/me?access_token={$accessToken}");
        } catch (\Exception $e) {
            return false;
        }

        $fbFields = json_decode($data);
        $existingUser = $this->getByFbId($fbFields->id);

        if ($existingUser) {
            return [
                'message' => 'User Already Exists!!',
                'data' => [
                    'fb_info' => $existingUser->fb_info,
                    'api_token' => $existingUser->api_token
                ],
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
}
