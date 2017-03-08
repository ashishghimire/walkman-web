<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\AppUser\AppUserRepositoryInterface', 'App\Repositories\AppUser\AppUserRepository');
        $this->app->bind('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Repositories\Incentive\IncentiveRepositoryInterface', 'App\Repositories\Incentive\IncentiveRepository');
        $this->app->bind('App\Repositories\Gift\GiftRepositoryInterface', 'App\Repositories\Gift\GiftRepository');
    }
}
