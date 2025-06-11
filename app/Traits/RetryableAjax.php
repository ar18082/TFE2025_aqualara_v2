<?php

namespace App\Traits;

use App\Services\RetryService;

trait RetryableAjax
{
    /**
     * Instance du service de retry
     */
    protected RetryService $retryService;

    /**
     * Initialise le service de retry
     */
    public function __construct()
    {
        $this->retryService = new RetryService();
    }

    /**
     * Exécute une requête AJAX avec retry
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    protected function retryAjaxRequest(string $method, string $url, array $data = [], array $headers = [])
    {
        $headers = array_merge($headers, [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-CSRF-TOKEN' => csrf_token()
        ]);

        return $this->retryService->executeWithRetry($method, $url, $data, $headers);
    }
} 