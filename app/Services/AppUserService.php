<?php

namespace App\Services;

use App\Repositories\AppUser\AppUserRepositoryInterface;
use Illuminate\Support\Facades\Hash;


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
     * @return bool
     */
    public function save($data)
    {
        $fbFields = json_decode($data);

        if (empty($fbFields)) {
            return false;
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

        return Hash::check($apiToken, $user->api_token);
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
    public function topContributors()
    {
        return $this->transformCollection($this->appUser->topContributors()->all());
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