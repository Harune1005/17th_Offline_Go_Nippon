<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
            if (Auth::check()) {
                $notifications = Auth::user()
                    ->notifications()
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $notifications = collect();
            }

            $view->with('notifications', $notifications);
        });

        // to provide the number of unread
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                $unreadNotifications = $user->unreadNotifications()->count();

                $unreadDMs = Message::where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
            } else {
                $unreadNotifications = 0;
                $unreadDMs = 0;
            }

            $view->with([
                'unreadNotifications' => $unreadNotifications,
                'unreadDMs' => $unreadDMs,
            ]);
        });
    }
}
