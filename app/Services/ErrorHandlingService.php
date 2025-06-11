<?php

namespace App\Services;

use App\Exceptions\AquaLaraException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ErrorNotification;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ErrorHandlingService
{
    /**
     * Niveaux de sévérité
     */
    private const SEVERITY_LEVELS = [
        'debug' => 0,
        'info' => 1,
        'warning' => 2,
        'error' => 3,
        'critical' => 4
    ];

    /**
     * Durée de mise en cache des erreurs (en minutes)
     */
    private const ERROR_CACHE_TTL = 60;

    /**
     * Nombre maximum d'erreurs en cache
     */
    private const MAX_CACHED_ERRORS = 100;

    /**
     * Gère une erreur
     *
     * @param Throwable $exception
     * @return void
     */
    public function handle(Throwable $exception): void
    {
        $errorData = $this->formatError($exception);
        
        // Journaliser l'erreur
        $this->logError($errorData);

        // Mettre en cache l'erreur
        $this->cacheError($errorData);

        // Envoyer une notification si nécessaire
        if ($this->shouldNotify($errorData)) {
            $this->sendNotification($errorData);
        }
    }

    /**
     * Formate une erreur
     *
     * @param Throwable $exception
     * @return array
     */
    private function formatError(Throwable $exception): array
    {
        $errorData = [
            'timestamp' => now(),
            'message' => $exception->getMessage(),
            'code' => $exception instanceof AquaLaraException ? $exception->getErrorCode() : 'UNKNOWN_ERROR',
            'severity' => $exception instanceof AquaLaraException ? $exception->getSeverity() : 'error',
            'context' => $exception instanceof AquaLaraException ? $exception->getContext() : [],
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'request' => [
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]
        ];

        return $errorData;
    }

    /**
     * Journalise une erreur
     *
     * @param array $errorData
     * @return void
     */
    private function logError(array $errorData): void
    {
        $logMessage = sprintf(
            "[%s] %s (Code: %s, Sévérité: %s)",
            $errorData['timestamp'],
            $errorData['message'],
            $errorData['code'],
            $errorData['severity']
        );

        $logContext = array_merge(
            $errorData['context'],
            [
                'file' => $errorData['file'],
                'line' => $errorData['line'],
                'request' => $errorData['request']
            ]
        );

        Log::channel('errors')->{$errorData['severity']}($logMessage, $logContext);
    }

    /**
     * Met en cache une erreur
     *
     * @param array $errorData
     * @return void
     */
    private function cacheError(array $errorData): void
    {
        $cacheKey = "error:{$errorData['code']}:" . md5($errorData['message']);
        
        // Limiter le nombre d'erreurs en cache
        $errorCount = Cache::get('error_count', 0);
        if ($errorCount >= self::MAX_CACHED_ERRORS) {
            Cache::forget('error_count');
        } else {
            Cache::increment('error_count');
        }

        Cache::put($cacheKey, $errorData, self::ERROR_CACHE_TTL * 60);
    }

    /**
     * Vérifie si une notification doit être envoyée
     *
     * @param array $errorData
     * @return bool
     */
    private function shouldNotify(array $errorData): bool
    {
        $severityLevel = self::SEVERITY_LEVELS[$errorData['severity']] ?? 0;
        $minSeverityLevel = self::SEVERITY_LEVELS['error'];

        return $severityLevel >= $minSeverityLevel;
    }

    /**
     * Envoie une notification d'erreur
     *
     * @param array $errorData
     * @return void
     */
    private function sendNotification(array $errorData): void
    {
        Notification::route('mail', config('app.error_notification_email'))
            ->notify(new ErrorNotification($errorData));
    }

    /**
     * Récupère les erreurs récentes
     *
     * @param int $limit
     * @return array
     */
    public function getRecentErrors(int $limit = 10): array
    {
        $errors = [];
        $keys = Cache::get('error_keys', []);

        foreach ($keys as $key) {
            if (count($errors) >= $limit) {
                break;
            }

            if ($error = Cache::get($key)) {
                $errors[] = $error;
            }
        }

        return $errors;
    }

    /**
     * Nettoie les erreurs en cache
     *
     * @return void
     */
    public function clearErrorCache(): void
    {
        Cache::forget('error_count');
        Cache::forget('error_keys');
    }
} 