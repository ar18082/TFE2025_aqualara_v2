<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class AssetOptimizationService
{
    /**
     * Optimise une image
     */
    public function optimizeImage(string $path, array $options = []): string
    {
        $config = Config::get('asset-optimization.image');
        $defaultOptions = [
            'max_width' => $config['max_width'],
            'max_height' => $config['max_height'],
            'quality' => $config['quality'],
            'format' => $config['format'],
        ];

        $options = array_merge($defaultOptions, $options);

        $image = Image::load(Storage::path($path));

        // Crée un nom de fichier optimisé
        $outputDir = Config::get('asset-optimization.output.directory');
        $optimizedPath = $outputDir . '/' . pathinfo($path, PATHINFO_FILENAME) . '.' . $options['format'];

        // Optimise l'image
        $image->fit(Manipulations::FIT_CONTAIN, $options['max_width'], $options['max_height'])
            ->quality($options['quality'])
            ->save(Storage::path($optimizedPath));

        return $optimizedPath;
    }

    /**
     * Optimise un fichier CSS
     */
    public function optimizeCss(string $content): string
    {
        $config = Config::get('asset-optimization.css');

        if (!$config['minify']) {
            return $content;
        }

        // Supprime les espaces inutiles
        $content = preg_replace('/\s+/', ' ', $content);
        
        if ($config['remove_comments']) {
            // Supprime les commentaires
            $content = preg_replace('/\/\*[\s\S]*?\*\//', '', $content);
        }
        
        if ($config['remove_last_semicolon']) {
            // Supprime les points-virgules en fin de règle
            $content = preg_replace('/;}/', '}', $content);
        }
        
        // Supprime les espaces autour des opérateurs
        $content = preg_replace('/\s*([\{\}\[\]\(\):;,])\s*/', '$1', $content);
        
        return trim($content);
    }

    /**
     * Optimise un fichier JavaScript
     */
    public function optimizeJs(string $content): string
    {
        $config = Config::get('asset-optimization.js');

        if (!$config['minify']) {
            return $content;
        }

        // Supprime les espaces inutiles
        $content = preg_replace('/\s+/', ' ', $content);
        
        if ($config['remove_comments']) {
            // Supprime les commentaires
            $content = preg_replace('/\/\/.*$/m', '', $content);
            $content = preg_replace('/\/\*[\s\S]*?\*\//', '', $content);
        }
        
        if ($config['remove_last_semicolon']) {
            // Supprime les points-virgules en fin de ligne
            $content = preg_replace('/;}/', '}', $content);
        }
        
        // Supprime les espaces autour des opérateurs
        $content = preg_replace('/\s*([\{\}\[\]\(\):;,])\s*/', '$1', $content);
        
        return trim($content);
    }

    /**
     * Optimise un fichier HTML
     */
    public function optimizeHtml(string $content): string
    {
        $config = Config::get('asset-optimization.html');

        if (!$config['minify']) {
            return $content;
        }

        // Supprime les espaces inutiles
        $content = preg_replace('/\s+/', ' ', $content);
        
        if ($config['remove_comments']) {
            // Supprime les commentaires HTML
            $content = preg_replace('/<!--[\s\S]*?-->/', '', $content);
        }
        
        if ($config['remove_attributes']) {
            // Supprime les attributs inutiles
            $content = preg_replace('/\s+(?:class|style|id)="[^"]*"/', '', $content);
        }
        
        // Minifie le CSS inline
        $content = preg_replace_callback('/style="([^"]*)"/', function($matches) {
            return 'style="' . $this->optimizeCss($matches[1]) . '"';
        }, $content);
        
        return trim($content);
    }

    /**
     * Vérifie si un fichier est déjà optimisé
     */
    public function isOptimized(string $path): bool
    {
        $outputDir = Config::get('asset-optimization.output.directory');
        return strpos($path, $outputDir . '/') === 0;
    }

    /**
     * Optimise tous les assets d'un dossier
     */
    public function optimizeDirectory(string $directory, array $options = []): array
    {
        if (!Config::get('asset-optimization.enabled')) {
            return [
                'success' => [],
                'failed' => [
                    [
                        'path' => $directory,
                        'error' => 'L\'optimisation des assets est désactivée'
                    ]
                ]
            ];
        }

        $results = [
            'success' => [],
            'failed' => [],
        ];

        $files = File::allFiles(Storage::path($directory));
        $preserveStructure = Config::get('asset-optimization.output.preserve_structure');

        foreach ($files as $file) {
            try {
                $relativePath = str_replace(Storage::path(''), '', $file->getPathname());
                
                if ($this->isOptimized($relativePath)) {
                    continue;
                }

                $extension = strtolower($file->getExtension());

                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        $optimizedPath = $this->optimizeImage($relativePath, $options);
                        break;
                    case 'css':
                        $content = File::get($file->getPathname());
                        $optimizedContent = $this->optimizeCss($content);
                        $optimizedPath = $this->getOptimizedPath($relativePath, $preserveStructure);
                        Storage::put($optimizedPath, $optimizedContent);
                        break;
                    case 'js':
                        $content = File::get($file->getPathname());
                        $optimizedContent = $this->optimizeJs($content);
                        $optimizedPath = $this->getOptimizedPath($relativePath, $preserveStructure);
                        Storage::put($optimizedPath, $optimizedContent);
                        break;
                    case 'html':
                        $content = File::get($file->getPathname());
                        $optimizedContent = $this->optimizeHtml($content);
                        $optimizedPath = $this->getOptimizedPath($relativePath, $preserveStructure);
                        Storage::put($optimizedPath, $optimizedContent);
                        break;
                    default:
                        continue 2;
                }

                $results['success'][] = [
                    'original' => $relativePath,
                    'optimized' => $optimizedPath,
                ];
            } catch (\Exception $e) {
                $results['failed'][] = [
                    'path' => $relativePath,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * Génère le chemin optimisé pour un fichier
     */
    private function getOptimizedPath(string $path, bool $preserveStructure): string
    {
        $outputDir = Config::get('asset-optimization.output.directory');
        
        if ($preserveStructure) {
            $dirname = dirname($path);
            return $outputDir . '/' . $dirname . '/' . basename($path);
        }
        
        return $outputDir . '/' . basename($path);
    }
} 