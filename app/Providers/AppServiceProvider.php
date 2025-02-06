<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Ensure user and profile image are available in every view that needs them
        View::composer('includes.topbar', function ($view) {
            $user = Auth::user();
            $profileImage = $user ? $user->getMedia('profile-images')->first() : null;
            $view->with(['user' => $user, 'profileImage' => $profileImage]);
        });
        Vite::prefetch(concurrency: 3);

    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register application services
    }

}
