<?php

namespace App\Providers;

use App\Services\PortalTransparenciaService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PortalTransparenciaService::class, function ($app) {
            return new PortalTransparenciaService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
