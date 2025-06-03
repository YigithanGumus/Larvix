<?php

namespace App\Providers;

use App\Repositories\AuthRepository\AuthRepository;
use App\Repositories\AuthRepository\Interfaces\IAuthRepository;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\BaseRepository\Interfaces\IBaseRepository;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       app()->bind(IAuthRepository::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
