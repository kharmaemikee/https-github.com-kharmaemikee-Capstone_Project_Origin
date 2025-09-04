<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Register authorization gates
        $this->registerAuthorizationGates();
    }

    /**
     * Register authorization gates for permit-based access control.
     */
    protected function registerAuthorizationGates(): void
    {
        // Gate to check if user can access resort features
        Gate::define('access-resort-features', function ($user) {
            if ($user->role !== 'resort_owner') {
                return false;
            }
            
            // Allow access to basic features (dashboard, account management)
            // But restrict main features (resort information) until permits are approved
            return $user->canAccessMainFeatures();
        });

        // Gate to check if user can access boat features
        Gate::define('access-boat-features', function ($user) {
            if ($user->role !== 'boat_owner') {
                return false;
            }
            
            // Allow access to basic features (dashboard, account management)
            // But restrict main features (boat information) until permits are approved
            return $user->canAccessMainFeatures();
        });

        // Gate to check if user can access basic features (always allowed for authenticated users)
        Gate::define('access-basic-features', function ($user) {
            return $user->canAccessBasicFeatures();
        });
    }
}
