<?php

namespace App\Repositories\User;


interface UserRepositoryInterface
{
	public function getSponsors();
	public function find($id);
}