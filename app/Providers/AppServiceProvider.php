<?php

namespace App\Providers;

use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\BaseRepository\Interfaces\Repository;
use App\Services\BaseService\BaseService;
use App\Services\BaseService\Interfaces\Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Service::class, BaseService::class);
        $this->app->bind(Repository::class, BaseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
