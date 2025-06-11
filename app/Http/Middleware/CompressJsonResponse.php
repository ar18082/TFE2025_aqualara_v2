<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompressJsonResponse
{
    /**
     * Taille minimale pour activer la compression (en octets)
     */
    private const MIN_SIZE = 1024;

    /**
     * Niveau de compression (0-9)
     */
    private const COMPRESSION_LEVEL = 6;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Vérifier si c'est une réponse JSON
        if (!$this->shouldCompress($response)) {
            return $response;
        }

        // Récupérer le contenu
        $content = $response->getContent();
        
        // Vérifier la taille
        if (strlen($content) < self::MIN_SIZE) {
            return $response;
        }

        // Compresser le contenu
        $compressed = gzencode($content, self::COMPRESSION_LEVEL);

        // Mettre à jour la réponse
        $response->setContent($compressed);
        $response->headers->set('Content-Encoding', 'gzip');
        $response->headers->set('Content-Length', strlen($compressed));

        return $response;
    }

    /**
     * Vérifie si la réponse doit être compressée
     *
     * @param Response $response
     * @return bool
     */
    private function shouldCompress(Response $response): bool
    {
        // Vérifier si c'est une réponse JSON
        if (!$response->headers->has('Content-Type')) {
            return false;
        }

        $contentType = $response->headers->get('Content-Type');
        if (!str_contains($contentType, 'application/json')) {
            return false;
        }

        // Vérifier si le client accepte la compression
        $request = request();
        if (!$request->headers->has('Accept-Encoding')) {
            return false;
        }

        return str_contains($request->headers->get('Accept-Encoding'), 'gzip');
    }
} 