<?php

namespace App\Traits;

use App\Services\EmailOptimizationService;

trait OptimizesEmails
{
    /**
     * Optimise le contenu HTML d'un email
     */
    protected function optimizeEmailContent(string $html): string
    {
        return app(EmailOptimizationService::class)->optimizeHtml($html);
    }

    /**
     * Optimise les images d'un email
     */
    protected function optimizeEmailImages(string $html): string
    {
        return app(EmailOptimizationService::class)->optimizeImages($html);
    }

    /**
     * Optimise une vue d'email
     */
    protected function optimizeEmailView(string $view, array $data = []): string
    {
        return app(EmailOptimizationService::class)->optimizeView($view, $data);
    }

    /**
     * Vérifie si un email est déjà optimisé
     */
    protected function isEmailOptimized(string $html): bool
    {
        return app(EmailOptimizationService::class)->isOptimized($html);
    }
} 