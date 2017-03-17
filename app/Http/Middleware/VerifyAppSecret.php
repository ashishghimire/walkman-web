<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ApiController;
use Closure;

class VerifyAppSecret extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty($request->header('app_secret')) || !($request->header('app_secret') === env('APP_SECRET'))) {
            return $this->respondParameterFailed('Cannot verify client');
        }

        return $next($request);
    }
}
