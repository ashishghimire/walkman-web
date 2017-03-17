<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ApiController;
use Closure;
use Response;
use App\Services\AppUserService;

/**
 * Class VerifyUserToken
 * @package App\Http\Middleware
 */
class VerifyUserToken extends ApiController
{
    /**
     * @var AppUserService
     */
    protected $appUser;

    /**
     * VerifyUserToken constructor.
     * @param AppUserService $appUser
     */
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
        if(!($request->header('fb_id') && $request->header('api_token'))) {
            return $this->respondParameterFailed('make sure you have fb_id and api_token in your header');
        }

        if(!$this->appUser->verify($request->header('fb_id'), $request->header('api_token'))) {
            return $this->respondNotVerified('user not verified');
        }

        return $next($request);
    }
}
