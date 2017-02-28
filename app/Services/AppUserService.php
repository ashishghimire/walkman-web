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
		$user = $this->getByFbId($fbId);
		
		if(!$user) {
			return false;
		}

		return Hash::check($apiToken, $user->api_token);
	}

	public function update($data)
	{
		return $this->appUser->update($data);
	}
}