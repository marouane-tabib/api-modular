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
use Illuminate\Support\Facades\Validator;
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
        $this->strongPasswordValidator();
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

    protected function strongPasswordValidator()
    {
        Validator::extend('strong_password', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $value);
        });
    
        Validator::replacer('strong_password', function ($message, $attribute, $rule, $parameters) {
            return 'The ' . $attribute . ' must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number.';
        });
    }
}
