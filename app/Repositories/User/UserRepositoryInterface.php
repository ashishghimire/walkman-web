<?php

namespace App\Repositories\User;


interface UserRepositoryInterface
{
	public function getSponsors();
	public function find($id);
	public function update($user, $data);
	public function changePassword($user, $data);
}