<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AppUserService;
//use Illuminate\Support\Facades\Hash;

class AppUserController extends ApiController
{
    /*use Illuminate\Support\Facades\Hash;
 'password' => Hash::make($request->newPassword)
 if (Hash::check('plain-text', $hashedPassword)) {
    // The passwords match...
    OwnNqEd55URsajytHah1SpRtGvEXHepq3eI5fNrOKqDZTrkWfcPT0aEqBiIU

    $2y$10$.ahzel3dK1ZtU1eh0Hk9Pus6zzmrGvpC541onwQXQaL5WS2Fef.yi
}*/
	
	protected $appUser;

	public function __construct(AppUserService $appUserService)
	{
		$this->appUser = $appUserService;
		$this->middleware('user.token')->except('store');
	}

	public function store()
	{
		//dd(Hash::make('nice2meetu')); //This is to create a password so that i can insert to db directly
		$apiToken = $this->appUser->save(request()->get('fb_info'));

		if(!$apiToken) {
			return $this->respondInternalError();
		}
			
		return $this->respondCreated('User Successfully Created', $apiToken);
	}

	public function index()
	{
		// dd(Hash::check('OwnNqEd55URsajytHah1SpRtGvEXHepq3eI5fNrOKqDZTrkWfcPT0aEqBiIU', '$2y$10$.ahzel3dK1ZtU1eh0Hk9Pus6zzmrGvpC541onwQXQaL5WS2Fef.yi'));
		// dd(AppUser::all());
	}

	public function submitScore()
	{
		if(!(request()->has('todays_distance')&& request()->has('golds'))) {
			return $this->respondParameterFailed('you need todays_distance and golds to submit score');
		}

		if(!$this->appUser->update(request()->header('fb_id'), request()->all())) {
			return $this->respondInternalError();
		}

		return $this->respondUpdated('User Successfully Updated');
	}

	public function leaderBoard()
	{
		return $this->respond([
            'top_contributors' =>$this->appUser->topContributors(),
        ]);
	}

}
