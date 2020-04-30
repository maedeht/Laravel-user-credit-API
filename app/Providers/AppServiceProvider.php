<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\UserServiceInterface;
use Schema;
use Illuminate\Support\ServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->injectServices();
    }

    private function injectServices()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}
