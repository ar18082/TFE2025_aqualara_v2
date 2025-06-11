<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    /**
     * Durée de cache par défaut (en secondes)
     */
    private const DEFAULT_TTL = 3600;

    /**
     * Préfixe pour les clés de cache
     */
    private const CACHE_PREFIX = 'aqualara:';

    /**
     * Récupère une donnée du cache ou l'exécute si non présente
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     */
    public function remember(string $key, callable $callback, ?int $ttl = null)
    {
        $cacheKey = $this->getCacheKey($key);
        $ttl = $ttl ?? self::DEFAULT_TTL;

        return Cache::remember($cacheKey, $ttl, $callback);
    }

    /**
     * Récupère une donnée du cache
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return Cache::get($this->getCacheKey($key));
    }

    /**
     * Stocke une donnée dans le cache
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return bool
     */
    public function put(string $key, $value, ?int $ttl = null): bool
    {
        $cacheKey = $this->getCacheKey($key);
        $ttl = $ttl ?? self::DEFAULT_TTL;

        return Cache::put($cacheKey, $value, $ttl);
    }

    /**
     * Supprime une donnée du cache
     *
     * @param string $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        return Cache::forget($this->getCacheKey($key));
    }

    /**
     * Vide le cache
     *
     * @return bool
     */
    public function flush(): bool
    {
        return Cache::flush();
    }

    /**
     * Vérifie si une donnée existe dans le cache
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Cache::has($this->getCacheKey($key));
    }

    /**
     * Incrémente une valeur dans le cache
     *
     * @param string $key
     * @param int $value
     * @return int
     */
    public function increment(string $key, int $value = 1): int
    {
        return Cache::increment($this->getCacheKey($key), $value);
    }

    /**
     * Décrémente une valeur dans le cache
     *
     * @param string $key
     * @param int $value
     * @return int
     */
    public function decrement(string $key, int $value = 1): int
    {
        return Cache::decrement($this->getCacheKey($key), $value);
    }

    /**
     * Stocke plusieurs données dans le cache
     *
     * @param array $values
     * @param int|null $ttl
     * @return bool
     */
    public function putMany(array $values, ?int $ttl = null): bool
    {
        $ttl = $ttl ?? self::DEFAULT_TTL;
        $prefixedValues = [];

        foreach ($values as $key => $value) {
            $prefixedValues[$this->getCacheKey($key)] = $value;
        }

        return Cache::putMany($prefixedValues, $ttl);
    }

    /**
     * Récupère plusieurs données du cache
     *
     * @param array $keys
     * @return array
     */
    public function getMany(array $keys): array
    {
        $prefixedKeys = array_map([$this, 'getCacheKey'], $keys);
        $values = Cache::getMany($prefixedKeys);

        $result = [];
        foreach ($values as $key => $value) {
            $result[str_replace(self::CACHE_PREFIX, '', $key)] = $value;
        }

        return $result;
    }

    /**
     * Génère une clé de cache unique
     *
     * @param string $key
     * @return string
     */
    private function getCacheKey(string $key): string
    {
        return self::CACHE_PREFIX . $key;
    }

    /**
     * Récupère les statistiques du cache Redis
     *
     * @return array
     */
    public function getStats(): array
    {
        $redis = Redis::connection('cache');
        $info = $redis->info();

        return [
            'hits' => $info['keyspace_hits'] ?? 0,
            'misses' => $info['keyspace_misses'] ?? 0,
            'memory_used' => $info['used_memory'] ?? 0,
            'memory_peak' => $info['used_memory_peak'] ?? 0,
            'connected_clients' => $info['connected_clients'] ?? 0,
        ];
    }
} 