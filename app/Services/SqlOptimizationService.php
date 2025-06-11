<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class SqlOptimizationService
{
    /**
     * Seuil de temps d'exécution en millisecondes pour considérer une requête comme lente
     */
    private const SLOW_QUERY_THRESHOLD = 100;

    /**
     * Nombre maximum de requêtes à exécuter dans une transaction
     */
    private const MAX_QUERIES_PER_TRANSACTION = 100;

    /**
     * Analyse une requête SQL et suggère des optimisations
     */
    public function analyzeQuery(string $sql, array $bindings = []): array
    {
        $startTime = microtime(true);
        $explain = DB::select('EXPLAIN ' . $sql, $bindings);
        $executionTime = (microtime(true) - $startTime) * 1000;

        $suggestions = [];
        $isSlow = $executionTime > self::SLOW_QUERY_THRESHOLD;

        // Analyse des suggestions d'optimisation
        foreach ($explain as $row) {
            if ($row->type === 'ALL') {
                $suggestions[] = 'Ajouter un index sur les colonnes utilisées dans la clause WHERE';
            }
            if ($row->Extra === 'Using temporary') {
                $suggestions[] = 'Optimiser la requête pour éviter l\'utilisation de tables temporaires';
            }
            if ($row->Extra === 'Using filesort') {
                $suggestions[] = 'Ajouter un index sur les colonnes utilisées dans ORDER BY';
            }
        }

        return [
            'sql' => $sql,
            'bindings' => $bindings,
            'execution_time' => $executionTime,
            'is_slow' => $isSlow,
            'suggestions' => $suggestions,
            'explain' => $explain,
        ];
    }

    /**
     * Optimise une requête Eloquent
     */
    public function optimizeEloquentQuery(EloquentBuilder $query): EloquentBuilder
    {
        // Ajout des index manquants
        $this->addMissingIndexes($query);

        // Optimisation des relations chargées
        $this->optimizeRelations($query);

        // Limitation du nombre de résultats si nécessaire
        $this->limitResults($query);

        return $query;
    }

    /**
     * Optimise une requête Query Builder
     */
    public function optimizeQueryBuilder(Builder $query): Builder
    {
        // Ajout des index manquants
        $this->addMissingIndexes($query);

        // Optimisation des jointures
        $this->optimizeJoins($query);

        // Limitation du nombre de résultats si nécessaire
        $this->limitResults($query);

        return $query;
    }

    /**
     * Ajoute les index manquants à une requête
     */
    private function addMissingIndexes($query): void
    {
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        $analysis = $this->analyzeQuery($sql, $bindings);

        if ($analysis['is_slow']) {
            foreach ($analysis['suggestions'] as $suggestion) {
                if (str_contains($suggestion, 'index')) {
                    Log::info('Index suggéré pour la requête', [
                        'sql' => $sql,
                        'suggestion' => $suggestion,
                    ]);
                }
            }
        }
    }

    /**
     * Optimise les relations chargées dans une requête Eloquent
     */
    private function optimizeRelations(EloquentBuilder $query): void
    {
        $relations = $query->getEagerLoads();
        
        foreach ($relations as $relation => $constraints) {
            // Vérifie si la relation est nécessaire
            if (!$this->isRelationNeeded($relation)) {
                $query->without($relation);
            }

            // Optimise les contraintes de la relation
            $this->optimizeRelationConstraints($query, $relation, $constraints);
        }
    }

    /**
     * Optimise les jointures dans une requête Query Builder
     */
    private function optimizeJoins(Builder $query): void
    {
        $joins = $query->getQuery()->joins ?? [];

        foreach ($joins as $join) {
            // Vérifie si la jointure est nécessaire
            if (!$this->isJoinNeeded($join)) {
                $query->getQuery()->joins = array_filter($joins, fn($j) => $j !== $join);
            }

            // Optimise les conditions de jointure
            $this->optimizeJoinConditions($query, $join);
        }
    }

    /**
     * Limite le nombre de résultats si nécessaire
     */
    private function limitResults($query): void
    {
        if (!$query->getQuery()->limit && !$query->getQuery()->offset) {
            $query->limit(self::MAX_QUERIES_PER_TRANSACTION);
        }
    }

    /**
     * Vérifie si une relation est nécessaire
     */
    private function isRelationNeeded(string $relation): bool
    {
        // Logique pour déterminer si une relation est nécessaire
        // À implémenter selon les besoins spécifiques
        return true;
    }

    /**
     * Vérifie si une jointure est nécessaire
     */
    private function isJoinNeeded($join): bool
    {
        // Logique pour déterminer si une jointure est nécessaire
        // À implémenter selon les besoins spécifiques
        return true;
    }

    /**
     * Optimise les contraintes d'une relation
     */
    private function optimizeRelationConstraints(EloquentBuilder $query, string $relation, $constraints): void
    {
        // Logique pour optimiser les contraintes d'une relation
        // À implémenter selon les besoins spécifiques
    }

    /**
     * Optimise les conditions d'une jointure
     */
    private function optimizeJoinConditions(Builder $query, $join): void
    {
        // Logique pour optimiser les conditions d'une jointure
        // À implémenter selon les besoins spécifiques
    }
} 