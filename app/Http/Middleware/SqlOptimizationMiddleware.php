<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SqlOptimizationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SqlOptimizationMiddleware
{
    /**
     * Instance du service d'optimisation SQL
     */
    private SqlOptimizationService $sqlOptimizationService;

    /**
     * Constructeur
     */
    public function __construct(SqlOptimizationService $sqlOptimizationService)
    {
        $this->sqlOptimizationService = $sqlOptimizationService;
    }

    /**
     * Gère la requête
     */
    public function handle(Request $request, Closure $next)
    {
        // Active le logging des requêtes SQL
        DB::enableQueryLog();

        // Exécute la requête
        $response = $next($request);

        // Analyse et optimise les requêtes SQL
        $this->analyzeAndOptimizeQueries();

        return $response;
    }

    /**
     * Analyse et optimise les requêtes SQL exécutées
     */
    private function analyzeAndOptimizeQueries(): void
    {
        $queries = DB::getQueryLog();

        foreach ($queries as $query) {
            $analysis = $this->sqlOptimizationService->analyzeQuery($query['query'], $query['bindings']);

            if ($analysis['is_slow']) {
                Log::warning('Requête SQL lente détectée', [
                    'sql' => $query['query'],
                    'bindings' => $query['bindings'],
                    'time' => $query['time'],
                    'suggestions' => $analysis['suggestions'],
                ]);
            }

            // Si des suggestions d'optimisation sont disponibles
            if (!empty($analysis['suggestions'])) {
                Log::info('Suggestions d\'optimisation pour la requête SQL', [
                    'sql' => $query['query'],
                    'suggestions' => $analysis['suggestions'],
                ]);
            }
        }
    }
} 