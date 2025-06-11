<?php

namespace App\Http\Controllers;

use App\Services\LazyLoadingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ComponentController extends Controller
{
    /**
     * Instance du service de lazy loading
     */
    private LazyLoadingService $lazyLoadingService;

    /**
     * Constructeur
     */
    public function __construct(LazyLoadingService $lazyLoadingService)
    {
        $this->lazyLoadingService = $lazyLoadingService;
    }

    /**
     * Charge un composant de manière asynchrone
     */
    public function load(string $component, Request $request)
    {
        try {
            // Vérifie si le composant existe
            if (!View::exists("components.{$component}")) {
                return response()->json(['error' => 'Composant non trouvé'], 404);
            }

            // Récupère les données du composant
            $data = $request->all();

            // Rendu du composant
            $html = View::make("components.{$component}", $data)->render();

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 