<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    protected function redirectTo($request)
    {
        if (!Auth::check()) {
            return route('login');
        }

        return match (Auth::user()->role) {
            'admin' => route('admin'),
            'resort_owner' => route('resort.owner.dashboard'),
            'boat_owner' => route('boat.owner.dashboard'),
            'tourist' => route('tourist.tourist'),
            default => route('dashboard'),
        };
    }
}
