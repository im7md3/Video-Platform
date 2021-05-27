<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        Inertia::share('locale', function () {
            return app()->getLocale();
        });
        Inertia::share('language', function () {
            return translations(
                resource_path('/lang/' . app()->getLocale() . '.json')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('update_videos',function($user){
            return $user->isAdmin();
        });
        Gate::define('update_users',function($user){
            return $user->isSuperAdmin();
        });
    }
}
