<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->routes(function () {
            // ...existing code...
        });

        // Remove the duplicate middleware registration
        // Route::aliasMiddleware('employee', \App\Http\Middleware\Employee::class);
        // Route::aliasMiddleware('manager', \App\Http\Middleware\Manager::class);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        // ...existing code...
    }
}