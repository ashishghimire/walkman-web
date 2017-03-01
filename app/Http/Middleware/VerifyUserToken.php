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
        if(!($request->header('fb_id') && $request->header('api_token'))) {
            return $this->failureResponse('make sure you have fb_id and api_token in your header', 422);
        }

        if(!$this->appUser->verify($request->header('fb_id'), $request->header('api_token'))) {
            return $this->failureResponse('user not verified', 403);
        }

        return $next($request);
    }

    protected function failureResponse($message, $statusCode)
    {
        return Response::json([
            'error' => $message
        ], $statusCode);
    }
}
