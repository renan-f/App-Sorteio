<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\UsersRepositoryInterface', 'App\Repositories\UsersRepositoryEloquent');
        $this->app->bind('App\Repositories\AwardsRepositoryInterface', 'App\Repositories\AwardsRepositoryEloquent');
        $this->app->bind('App\Repositories\SweepstakesRepositoryInterface', 'App\Repositories\SweepstakesRepositoryEloquent');
        $this->app->bind('App\Repositories\ParticipantsRepositoryInterface', 'App\Repositories\ParticipantsRepositoryEloquent');
        $this->app->bind('App\Repositories\SweepstakeResultRepositoryInterface', 'App\Repositories\SweepstakeResultRepositoryEloquent');
    }
}
