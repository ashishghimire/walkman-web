<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Services\AppUserService;

class VerifyUserToken
{
    protected $appUser;
    
    public function __construct(AppUserService $appUser)
    {
        $this->appUser = $appUser;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!($request->has('fb_id') && $request->has('api_token'))) {
            return $this->failureResponse('make sure you have both fb_id and api_token');
        }

        if(!$this->appUser->verify($request->get('fb_id'), $request->get('api_token'))) {
            return $this->failureResponse('user not verified');
        }

        return $next($request);
    }

    protected function failureResponse($message)
    {
        return Response::json([
            'error' => $message
        ], 422);
    }
}
