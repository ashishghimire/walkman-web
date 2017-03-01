<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;

class UserService
{
	protected $user;

	public function __construct(UserRepositoryInterface $user)
	{
		$this->user = $user;
	}
	
	public function getSponsors()
	{
		return $this->user->getSponsors();
	}

	public function find($id)
	{
		try {
			$user = $this->user->find($id);
		} catch (\Exception $e) {
			return null;
		}

		return $user;
	}
}