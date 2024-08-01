<?php

namespace App\Repositories\BaseRepository;

use App\Services\BaseService\BaseService;
use App\Services\BaseService\Interfaces\Service;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Service::class, BaseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
