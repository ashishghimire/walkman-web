<?php

namespace App\Repositories\AppUser;

use App\AppUser;
use Illuminate\Support\Facades\Hash;

class AppUserRepository implements AppUserRepositoryInterface
{
	
	protected $appUser;

	public function __construct(AppUser $appUser)
	{
		$this->appUser = $appUser;
	}

	public function save($input) 
	{
		$apiToken = str_random(60);
		$input['api_token'] = Hash::make($apiToken);
		
		if($this->appUser->create($input)) {
			return $apiToken;
		}

		return false;
	}

	public function getByFbId($fbId)
	{
		return $this->appUser->where('fb_id', $fbId)->firstOrFail();
	}

	public function update($data)
	{
		$user = $this->getByFbId($data['fb_id']);
		
		if(!$user) {
			return false;
		}

		$user->total_distance += $data['todays_distance'];
		$user->golds = $data['golds'];
		$user->personal_best = max($user->personal_best, $data['todays_distance']);
		$user->todays_distance = $data['todays_distance'];

		if($user->save()) {
			return true;
		}

		return false;
	}
}