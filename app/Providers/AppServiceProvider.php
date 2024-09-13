<?php

namespace App\Providers;

use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\BaseRepository\Interfaces\Repository;
use App\Services\BaseService\BaseService;
use App\Services\BaseService\Interfaces\Service;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->configureRateLimiting();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('user_throttle', function (Request $request) {
            return [
                Limit::perSecond(1)->by(Auth::user()?->id),
                Limit::perMinute(30)->by($request->ip()),
                Limit::perDay(10000)->by($request->ip()),
            ];
        });
    }
}
