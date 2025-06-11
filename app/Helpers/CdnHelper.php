<?php

namespace App\Helpers;

use App\Services\CdnService;

if (!function_exists('cdn_url')) {
    /**
     * Génère une URL CDN pour un asset
     */
    function cdn_url(string $path): string
    {
        return app(CdnService::class)->url($path);
    }
}

if (!function_exists('cdn_asset')) {
    /**
     * Génère une balise HTML pour un asset CDN
     */
    function cdn_asset(string $path, array $attributes = []): string
    {
        $url = cdn_url($path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'css':
                return '<link rel="stylesheet" href="' . $url . '" ' . html_attributes($attributes) . '>';
            case 'js':
                return '<script src="' . $url . '" ' . html_attributes($attributes) . '></script>';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'svg':
                return '<img src="' . $url . '" ' . html_attributes($attributes) . '>';
            default:
                return $url;
        }
    }
}

if (!function_exists('html_attributes')) {
    /**
     * Génère une chaîne d'attributs HTML
     */
    function html_attributes(array $attributes): string
    {
        return collect($attributes)
            ->map(function ($value, $key) {
                return $key . '="' . htmlspecialchars($value) . '"';
            })
            ->implode(' ');
    }
} 