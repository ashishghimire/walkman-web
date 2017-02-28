<?php

namespace App\Repositories\AppUser;


interface AppUserRepositoryInterface
{
	public function save($input);
	public function getByFbId($fbId);
	public function update($data);
}