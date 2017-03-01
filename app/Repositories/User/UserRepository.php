<?php

namespace App\Repositories\User;

use App\User;

class UserRepository implements UserRepositoryInterface
{
	protected $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function getSponsors()
	{
		return $this->user->where('role', 'sponsor')->get();
	}

	public function find($id)
	{
		return $this->user->findOrFail($id);
	}
}