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
        $this->app->bind(
            'App\Repositories\Merchant\MerchantsRepositoryInterface',
            'App\Repositories\Merchant\MerchantsRepository'
        );

        $this->app->bind(
            'App\Repositories\User\UsersRepositoryInterface',
            'App\Repositories\User\UsersRepository'
        );

        $this->app->bind(
            'App\Repositories\Color\ColorsRepositoryInterface',
            'App\Repositories\Color\ColorsRepository'
        );

        $this->app->bind(
            'App\Repositories\Item\ItemsRepositoryInterface',
            'App\Repositories\Item\ItemsRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
