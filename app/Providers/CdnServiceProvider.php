<?php

namespace App\Providers;

use App\Services\CdnService;
use Illuminate\Support\ServiceProvider;

class CdnServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l'application
     */
    public function register(): void
    {
        $this->app->singleton(CdnService::class, function ($app) {
            return new CdnService();
        });
    }

    /**
     * Démarre les services de l'application
     */
    public function boot(): void
    {
        //
    }
} 