<?php

namespace App\Providers;

use App\Services\AssetOptimizationService;
use Illuminate\Support\ServiceProvider;

class AssetOptimizationServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l'application
     */
    public function register(): void
    {
        $this->app->singleton(AssetOptimizationService::class, function ($app) {
            return new AssetOptimizationService();
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