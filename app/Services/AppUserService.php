<?php

namespace App\Services;

use App\Repositories\AppUser\AppUserRepositoryInterface;
use Illuminate\Support\Facades\Hash;


class AppUserService
{
	protected $appUser;

	public function __construct(AppUserRepositoryInterface $appUser) {
		$this->appUser = $appUser;
	}

	public function save($data)
	{
		$fbFields = json_decode($data);

		if(empty($fbFields)) {
			return false;
		}

		$input = [];
		$input['fb_id'] = $fbFields->id;
		$input['fb_info'] = $fbFields;

		return $this->appUser->save($input);
	}

	public function getByFbId($fbId)
	{
		try{
			$user = $this->appUser->getByFbId($fbId);
		} catch(\Exception $e) {
			return false;
		}
		return $user;
	}

	public function verify($fbId, $apiToken)
	{
		if(!is_numeric($fbId)) {
			return false;
		}
		
		$user = $this->getByFbId($fbId);
		
		if(!$user) {
			return false;
		}

		return Hash::check($apiToken, $user->api_token);
	}

	public function update($fbId, $data)
	{
		return $this->appUser->update($fbId, $data);
	}

	public function topContributors()
	{
		return $this->transformCollection($this->appUser->topContributors()->all());
	}

	public function transformCollection($items)
    {
        return array_map([$this, 'transform'], $items);
    }

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