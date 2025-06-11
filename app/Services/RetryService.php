<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RetryService
{
    /**
     * Nombre maximum de tentatives
     */
    private const MAX_RETRIES = 3;

    /**
     * Délai initial entre les tentatives (en millisecondes)
     */
    private const INITIAL_DELAY = 1000;

    /**
     * Facteur de multiplication du délai entre les tentatives
     */
    private const BACKOFF_FACTOR = 2;

    /**
     * Taille maximale du cache pour les requêtes échouées
     */
    private const MAX_FAILED_REQUESTS = 1000;

    /**
     * Durée de conservation des requêtes échouées (en minutes)
     */
    private const FAILED_REQUESTS_TTL = 60;

    /**
     * Exécute une requête avec système de retry
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed
     * @throws \Exception
     */
    public function executeWithRetry(string $method, string $url, array $data = [], array $headers = [])
    {
        $attempts = 0;
        $lastError = null;
        $cacheKey = $this->getCacheKey($method, $url, $data);

        // Vérifier si la requête est en cache des échecs
        if ($this->isRequestFailed($cacheKey)) {
            throw new \Exception("La requête a échoué précédemment et est temporairement bloquée.");
        }

        while ($attempts < self::MAX_RETRIES) {
            try {
                $response = Http::withHeaders($headers)
                    ->timeout(30)
                    ->$method($url, $data);

                if ($response->successful()) {
                    return $response->json();
                }

                $lastError = $response->status();
                $attempts++;
                
                if ($attempts < self::MAX_RETRIES) {
                    $delay = $this->calculateDelay($attempts);
                    Log::warning("Tentative {$attempts} échouée pour {$url}. Nouvelle tentative dans {$delay}ms");
                    usleep($delay * 1000);
                }
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                $attempts++;
                
                if ($attempts < self::MAX_RETRIES) {
                    $delay = $this->calculateDelay($attempts);
                    Log::warning("Exception lors de la tentative {$attempts} pour {$url}: {$lastError}. Nouvelle tentative dans {$delay}ms");
                    usleep($delay * 1000);
                }
            }
        }

        // Marquer la requête comme échouée dans le cache
        $this->markRequestAsFailed($cacheKey);

        throw new \Exception("Échec après {$attempts} tentatives. Dernière erreur: {$lastError}");
    }

    /**
     * Calcule le délai pour la prochaine tentative
     *
     * @param int $attempt
     * @return int
     */
    private function calculateDelay(int $attempt): int
    {
        return self::INITIAL_DELAY * pow(self::BACKOFF_FACTOR, $attempt - 1);
    }

    /**
     * Génère une clé de cache unique pour la requête
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @return string
     */
    private function getCacheKey(string $method, string $url, array $data): string
    {
        return "failed_request:" . md5($method . $url . json_encode($data));
    }

    /**
     * Vérifie si une requête est marquée comme échouée
     *
     * @param string $cacheKey
     * @return bool
     */
    private function isRequestFailed(string $cacheKey): bool
    {
        return Cache::has($cacheKey);
    }

    /**
     * Marque une requête comme échouée dans le cache
     *
     * @param string $cacheKey
     * @return void
     */
    private function markRequestAsFailed(string $cacheKey): void
    {
        // Limiter la taille du cache
        $failedRequests = Cache::get('failed_requests_count', 0);
        if ($failedRequests >= self::MAX_FAILED_REQUESTS) {
            Cache::forget('failed_requests_count');
        } else {
            Cache::increment('failed_requests_count');
        }

        Cache::put($cacheKey, true, self::FAILED_REQUESTS_TTL * 60);
    }
} 