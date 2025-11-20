<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Gate::define('admin', function ($user) {
            return $user->role_id === User::ADMIN_ROLE_ID;
        });

        View::composer('*', function ($view) {
            $notifications = auth()->check()
                ? auth()->user()->notifications()->orderBy('created_at', 'desc')->get()
                : collect();

            $view->with('notifications', $notifications);
        });
    }
}
