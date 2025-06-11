<?php

namespace App\Providers;

use App\Services\EmailOptimizationService;
use Illuminate\Support\ServiceProvider;

class EmailOptimizationServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l'application
     */
    public function register(): void
    {
        $this->app->singleton(EmailOptimizationService::class, function ($app) {
            return new EmailOptimizationService();
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