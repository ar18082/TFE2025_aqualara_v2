<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class EmailOptimizationService
{
    /**
     * Optimise le contenu HTML d'un email
     */
    public function optimizeHtml(string $html): string
    {
        // Supprime les espaces inutiles
        $html = preg_replace('/\s+/', ' ', $html);
        
        // Supprime les commentaires HTML
        $html = preg_replace('/<!--[\s\S]*?-->/', '', $html);
        
        // Supprime les attributs inutiles
        $html = preg_replace('/\s+(?:class|style|id)="[^"]*"/', '', $html);
        
        // Minifie le CSS inline
        $html = preg_replace_callback('/style="([^"]*)"/', function($matches) {
            return 'style="' . $this->minifyCss($matches[1]) . '"';
        }, $html);
        
        return trim($html);
    }

    /**
     * Optimise les images d'un email
     */
    public function optimizeImages(string $html): string
    {
        // Trouve toutes les images dans le HTML
        preg_match_all('/<img[^>]+>/i', $html, $matches);
        
        foreach ($matches[0] as $imgTag) {
            // Extrait l'URL de l'image
            preg_match('/src="([^"]*)"/', $imgTag, $src);
            
            if (isset($src[1])) {
                $imagePath = $src[1];
                
                // Si l'image est stockée localement
                if (Storage::exists($imagePath)) {
                    // Optimise l'image
                    $optimizedPath = $this->optimizeImage($imagePath);
                    
                    // Remplace l'URL de l'image par la version optimisée
                    $html = str_replace($imagePath, $optimizedPath, $html);
                }
            }
        }
        
        return $html;
    }

    /**
     * Optimise une image spécifique
     */
    private function optimizeImage(string $path): string
    {
        $image = Image::load(Storage::path($path));
        
        // Crée un nom de fichier optimisé
        $optimizedPath = 'optimized/' . pathinfo($path, PATHINFO_FILENAME) . '.jpg';
        
        // Optimise l'image
        $image->fit(Manipulations::FIT_CONTAIN, 800, 600)
            ->quality(80)
            ->save(Storage::path($optimizedPath));
        
        return $optimizedPath;
    }

    /**
     * Minifie le CSS
     */
    private function minifyCss(string $css): string
    {
        // Supprime les espaces inutiles
        $css = preg_replace('/\s+/', ' ', $css);
        
        // Supprime les points-virgules en fin de règle
        $css = preg_replace('/;}/', '}', $css);
        
        // Supprime les espaces autour des opérateurs
        $css = preg_replace('/\s*([\{\}\[\]\(\):;,])\s*/', '$1', $css);
        
        return trim($css);
    }

    /**
     * Optimise une vue d'email
     */
    public function optimizeView(string $view, array $data = []): string
    {
        // Récupère le contenu HTML de la vue
        $html = View::make($view, $data)->render();
        
        // Optimise le HTML
        $html = $this->optimizeHtml($html);
        
        // Optimise les images
        $html = $this->optimizeImages($html);
        
        return $html;
    }

    /**
     * Vérifie si un email est déjà optimisé
     */
    public function isOptimized(string $html): bool
    {
        // Vérifie si l'email contient des images optimisées
        if (preg_match('/src="optimized\//', $html)) {
            return true;
        }
        
        // Vérifie si le HTML est déjà minifié
        if (preg_match('/\s{2,}/', $html)) {
            return false;
        }
        
        return true;
    }
} 