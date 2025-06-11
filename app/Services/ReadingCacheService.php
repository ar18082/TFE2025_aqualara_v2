<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Collection;

class ReadingCacheService
{
    /**
     * Durée de cache pour les relevés (en secondes)
     */
    private const READING_CACHE_TTL = 1800; // 30 minutes

    /**
     * Préfixe pour les clés de cache des relevés
     */
    private const READING_CACHE_PREFIX = 'readings:';

    /**
     * Instance du service de cache principal
     */
    private CacheService $cacheService;

    /**
     * Constructeur
     */
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Récupère les derniers relevés d'un client avec cache
     */
    public function getLastReadings(Client $client): array
    {
        $cacheKey = $this->getCacheKey("last_readings:{$client->Codecli}");
        
        return $this->cacheService->remember($cacheKey, function () use ($client) {
            return [
                'heating' => $client->relChaufs()->latest()->first(),
                'hot_water' => $client->relEauCs()->latest()->first(),
                'cold_water' => $client->relEauFs()->latest()->first(),
                'electricity' => $client->relElecs()->latest()->first(),
                'gas' => $client->relGazs()->latest()->first(),
            ];
        }, self::READING_CACHE_TTL);
    }

    /**
     * Récupère l'historique des relevés d'un client avec cache
     */
    public function getReadingHistory(Client $client, string $type, int $limit = 12): Collection
    {
        $cacheKey = $this->getCacheKey("history:{$client->Codecli}:{$type}:{$limit}");
        
        return $this->cacheService->remember($cacheKey, function () use ($client, $type, $limit) {
            return match ($type) {
                'heating' => $client->relChaufs()->latest()->take($limit)->get(),
                'hot_water' => $client->relEauCs()->latest()->take($limit)->get(),
                'cold_water' => $client->relEauFs()->latest()->take($limit)->get(),
                'electricity' => $client->relElecs()->latest()->take($limit)->get(),
                'gas' => $client->relGazs()->latest()->take($limit)->get(),
                default => collect(),
            };
        }, self::READING_CACHE_TTL);
    }

    /**
     * Récupère les statistiques des relevés d'un client avec cache
     */
    public function getReadingStats(Client $client): array
    {
        $cacheKey = $this->getCacheKey("stats:{$client->Codecli}");
        
        return $this->cacheService->remember($cacheKey, function () use ($client) {
            return [
                'heating' => [
                    'total' => $client->relChaufs()->count(),
                    'last_month' => $client->relChaufs()->whereMonth('created_at', now()->month)->count(),
                    'average' => $client->relChaufs()->avg('value'),
                ],
                'hot_water' => [
                    'total' => $client->relEauCs()->count(),
                    'last_month' => $client->relEauCs()->whereMonth('created_at', now()->month)->count(),
                    'average' => $client->relEauCs()->avg('value'),
                ],
                'cold_water' => [
                    'total' => $client->relEauFs()->count(),
                    'last_month' => $client->relEauFs()->whereMonth('created_at', now()->month)->count(),
                    'average' => $client->relEauFs()->avg('value'),
                ],
                'electricity' => [
                    'total' => $client->relElecs()->count(),
                    'last_month' => $client->relElecs()->whereMonth('created_at', now()->month)->count(),
                    'average' => $client->relElecs()->avg('value'),
                ],
                'gas' => [
                    'total' => $client->relGazs()->count(),
                    'last_month' => $client->relGazs()->whereMonth('created_at', now()->month)->count(),
                    'average' => $client->relGazs()->avg('value'),
                ],
            ];
        }, self::READING_CACHE_TTL);
    }

    /**
     * Récupère les relevés par période avec cache
     */
    public function getReadingsByPeriod(Client $client, string $type, string $startDate, string $endDate): Collection
    {
        $cacheKey = $this->getCacheKey("period:{$client->Codecli}:{$type}:{$startDate}:{$endDate}");
        
        return $this->cacheService->remember($cacheKey, function () use ($client, $type, $startDate, $endDate) {
            return match ($type) {
                'heating' => $client->relChaufs()->whereBetween('created_at', [$startDate, $endDate])->get(),
                'hot_water' => $client->relEauCs()->whereBetween('created_at', [$startDate, $endDate])->get(),
                'cold_water' => $client->relEauFs()->whereBetween('created_at', [$startDate, $endDate])->get(),
                'electricity' => $client->relElecs()->whereBetween('created_at', [$startDate, $endDate])->get(),
                'gas' => $client->relGazs()->whereBetween('created_at', [$startDate, $endDate])->get(),
                default => collect(),
            };
        }, self::READING_CACHE_TTL);
    }

    /**
     * Vide le cache des relevés d'un client
     */
    public function flushClientReadings(Client $client): bool
    {
        $pattern = $this->getCacheKey("*:{$client->Codecli}:*");
        return $this->cacheService->flush();
    }

    /**
     * Génère une clé de cache unique pour les relevés
     */
    private function getCacheKey(string $key): string
    {
        return self::READING_CACHE_PREFIX . $key;
    }
} 