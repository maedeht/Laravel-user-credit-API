<?php

namespace App\Providers;

use App\Services\ArticleService;
use App\Services\ArticleServiceInterface;
use App\Services\CommentService;
use App\Services\CommentServiceIterface;
use App\Services\InvoiceService;
use App\Services\InvoiceServiceInterface;
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
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
        $this->app->bind(CommentServiceIterface::class, CommentService::class);
        $this->app->bind(InvoiceServiceInterface::class, InvoiceService::class);
    }
}
