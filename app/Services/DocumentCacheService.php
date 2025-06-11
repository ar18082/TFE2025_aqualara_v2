<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Document;
use Illuminate\Support\Collection;

class DocumentCacheService
{
    /**
     * Durée de cache pour les documents (en secondes)
     */
    private const DOCUMENT_CACHE_TTL = 3600; // 1 heure

    /**
     * Préfixe pour les clés de cache des documents
     */
    private const DOCUMENT_CACHE_PREFIX = 'documents:';

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
     * Récupère les documents d'un client avec cache
     */
    public function getClientDocuments(Client $client): Collection
    {
        $cacheKey = $this->getCacheKey("client:{$client->Codecli}");
        
        return $this->cacheService->remember($cacheKey, function () use ($client) {
            return $client->documents()->latest()->get();
        }, self::DOCUMENT_CACHE_TTL);
    }

    /**
     * Récupère les documents par type avec cache
     */
    public function getDocumentsByType(Client $client, string $type): Collection
    {
        $cacheKey = $this->getCacheKey("client:{$client->Codecli}:type:{$type}");
        
        return $this->cacheService->remember($cacheKey, function () use ($client, $type) {
            return $client->documents()->where('type', $type)->latest()->get();
        }, self::DOCUMENT_CACHE_TTL);
    }

    /**
     * Récupère les documents par période avec cache
     */
    public function getDocumentsByPeriod(Client $client, string $startDate, string $endDate): Collection
    {
        $cacheKey = $this->getCacheKey("client:{$client->Codecli}:period:{$startDate}:{$endDate}");
        
        return $this->cacheService->remember($cacheKey, function () use ($client, $startDate, $endDate) {
            return $client->documents()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->latest()
                ->get();
        }, self::DOCUMENT_CACHE_TTL);
    }

    /**
     * Récupère les statistiques des documents d'un client avec cache
     */
    public function getDocumentStats(Client $client): array
    {
        $cacheKey = $this->getCacheKey("client:{$client->Codecli}:stats");
        
        return $this->cacheService->remember($cacheKey, function () use ($client) {
            return [
                'total' => $client->documents()->count(),
                'by_type' => $client->documents()->selectRaw('type, count(*) as count')->groupBy('type')->get(),
                'by_month' => $client->documents()
                    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
                    ->groupBy('month')
                    ->orderBy('month', 'desc')
                    ->take(12)
                    ->get(),
                'total_size' => $client->documents()->sum('size'),
            ];
        }, self::DOCUMENT_CACHE_TTL);
    }

    /**
     * Récupère un document spécifique avec cache
     */
    public function getDocument(Document $document): ?Document
    {
        $cacheKey = $this->getCacheKey("document:{$document->id}");
        
        return $this->cacheService->remember($cacheKey, function () use ($document) {
            return $document->fresh();
        }, self::DOCUMENT_CACHE_TTL);
    }

    /**
     * Vide le cache des documents d'un client
     */
    public function flushClientDocuments(Client $client): bool
    {
        $pattern = $this->getCacheKey("client:{$client->Codecli}:*");
        return $this->cacheService->flush();
    }

    /**
     * Vide le cache d'un document spécifique
     */
    public function flushDocument(Document $document): bool
    {
        $key = $this->getCacheKey("document:{$document->id}");
        return $this->cacheService->forget($key);
    }

    /**
     * Génère une clé de cache unique pour les documents
     */
    private function getCacheKey(string $key): string
    {
        return self::DOCUMENT_CACHE_PREFIX . $key;
    }
} 