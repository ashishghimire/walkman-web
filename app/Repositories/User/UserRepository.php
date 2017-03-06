<?php

namespace App\Repositories\User;
use Storage;
use File;
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

	public function update($user, $data)
	{
		$user->name = $data['name'];
		$user->email = $data['email'];
		
			if(!empty($data['photo'])) {
				
				$fileName = Storage::putFile('profile_pictures', $data['photo']);

				if(!empty($user->photo)) {
	        		if(File::exists(storage_path("app/{$user->photo}"))) {
	        			Storage::delete($user->photo);
	        		}
	        	}
            	$user->photo = $fileName;
	    	}
	        else {
	        	if(isset($data['image-deleted'])) {
	        		Storage::delete($user->photo);
	        		$user->photo = null;
	        	}
	        }
		if($user->save()) {
			return true;
		}

		return false;
	}

	public function changePassword($user, $data)
	{
		$user->password = bcrypt($data['password']);

		if ($user->save()) {
			return true;
		}

		return false;
	}
}