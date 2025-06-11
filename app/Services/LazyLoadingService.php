<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class LazyLoadingService
{
    /**
     * Image par défaut pour le placeholder
     */
    private const DEFAULT_PLACEHOLDER = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

    /**
     * Classe CSS pour le lazy loading
     */
    private const LAZY_CLASS = 'lazy-load';

    /**
     * Convertit une image en version lazy loading
     */
    public function makeImageLazy(string $src, ?string $alt = null, ?string $class = null): string
    {
        $attributes = [
            'data-src' => $src,
            'src' => self::DEFAULT_PLACEHOLDER,
            'class' => self::LAZY_CLASS . ' ' . ($class ?? ''),
            'alt' => $alt ?? '',
        ];

        return '<img ' . $this->buildAttributes($attributes) . '>';
    }

    /**
     * Convertit une liste d'images en version lazy loading
     */
    public function makeImagesLazy(array $images): array
    {
        return array_map(function ($image) {
            return $this->makeImageLazy(
                $image['src'] ?? '',
                $image['alt'] ?? null,
                $image['class'] ?? null
            );
        }, $images);
    }

    /**
     * Crée un composant lazy loading
     */
    public function makeComponentLazy(string $component, array $data = []): string
    {
        $id = 'lazy-component-' . Str::random(8);
        
        $attributes = [
            'id' => $id,
            'class' => self::LAZY_CLASS,
            'data-component' => $component,
            'data-props' => json_encode($data),
        ];

        return '<div ' . $this->buildAttributes($attributes) . '></div>';
    }

    /**
     * Crée un script de lazy loading
     */
    public function generateLazyLoadingScript(): string
    {
        return View::make('components.lazy-loading-script')->render();
    }

    /**
     * Construit une chaîne d'attributs HTML
     */
    private function buildAttributes(array $attributes): string
    {
        return collect($attributes)
            ->filter()
            ->map(function ($value, $key) {
                return $key . '="' . htmlspecialchars($value) . '"';
            })
            ->implode(' ');
    }
} 