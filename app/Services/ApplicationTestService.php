<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class ApplicationTestService
{
    /**
     * Exécute tous les tests de l'application
     */
    public function runAllTests(): array
    {
        $results = [
            'database' => $this->testDatabase(),
            'cache' => $this->testCache(),
            'storage' => $this->testStorage(),
            'mail' => $this->testMail(),
            'queue' => $this->testQueue(),
            'logging' => $this->testLogging(),
            'config' => $this->testConfig(),
            'routes' => $this->testRoutes(),
            'views' => $this->testViews(),
            'optimization' => $this->testOptimization(),
        ];

        return $results;
    }

    /**
     * Teste la connexion à la base de données
     */
    private function testDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'status' => 'success',
                'message' => 'Connexion à la base de données réussie',
                'details' => [
                    'driver' => DB::connection()->getDriverName(),
                    'database' => DB::connection()->getDatabaseName(),
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur de connexion à la base de données',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste le système de cache
     */
    private function testCache(): array
    {
        try {
            $key = 'test_cache_' . time();
            Cache::put($key, 'test_value', 60);
            $value = Cache::get($key);
            Cache::forget($key);

            return [
                'status' => 'success',
                'message' => 'Système de cache fonctionnel',
                'details' => [
                    'driver' => Config::get('cache.default'),
                    'value' => $value
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur du système de cache',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste le système de stockage
     */
    private function testStorage(): array
    {
        try {
            $testFile = 'test_' . time() . '.txt';
            Storage::put($testFile, 'test_content');
            $exists = Storage::exists($testFile);
            $content = Storage::get($testFile);
            Storage::delete($testFile);

            return [
                'status' => 'success',
                'message' => 'Système de stockage fonctionnel',
                'details' => [
                    'driver' => Config::get('filesystems.default'),
                    'exists' => $exists,
                    'content' => $content
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur du système de stockage',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste le système d'envoi d'emails
     */
    private function testMail(): array
    {
        try {
            Mail::raw('Test email', function($message) {
                $message->to('test@example.com')
                        ->subject('Test Email');
            });

            return [
                'status' => 'success',
                'message' => 'Système d\'emails fonctionnel',
                'details' => [
                    'driver' => Config::get('mail.default'),
                    'from' => Config::get('mail.from.address')
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur du système d\'emails',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste le système de files d'attente
     */
    private function testQueue(): array
    {
        try {
            $job = new \Illuminate\Foundation\Bus\Dispatchable;
            dispatch($job);

            return [
                'status' => 'success',
                'message' => 'Système de files d\'attente fonctionnel',
                'details' => [
                    'driver' => Config::get('queue.default'),
                    'connection' => Config::get('queue.connections.' . Config::get('queue.default') . '.driver')
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur du système de files d\'attente',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste le système de logging
     */
    private function testLogging(): array
    {
        try {
            $message = 'Test log message ' . time();
            Log::info($message);

            return [
                'status' => 'success',
                'message' => 'Système de logging fonctionnel',
                'details' => [
                    'channel' => Config::get('logging.default'),
                    'test_message' => $message
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur du système de logging',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste la configuration de l'application
     */
    private function testConfig(): array
    {
        try {
            $config = [
                'app' => [
                    'name' => Config::get('app.name'),
                    'env' => Config::get('app.env'),
                    'debug' => Config::get('app.debug'),
                ],
                'mail' => [
                    'driver' => Config::get('mail.default'),
                    'from' => Config::get('mail.from'),
                ],
                'queue' => [
                    'driver' => Config::get('queue.default'),
                ],
                'cache' => [
                    'driver' => Config::get('cache.default'),
                ],
            ];

            return [
                'status' => 'success',
                'message' => 'Configuration de l\'application valide',
                'details' => $config
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur de la configuration',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste les routes de l'application
     */
    private function testRoutes(): array
    {
        try {
            $routes = collect(Route::getRoutes())->map(function ($route) {
                return [
                    'uri' => $route->uri(),
                    'methods' => $route->methods(),
                    'name' => $route->getName(),
                ];
            });

            return [
                'status' => 'success',
                'message' => 'Routes de l\'application valides',
                'details' => [
                    'total_routes' => $routes->count(),
                    'routes' => $routes
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur des routes',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste les vues de l'application
     */
    private function testViews(): array
    {
        try {
            $views = collect(File::allFiles(resource_path('views')))
                ->map(function ($file) {
                    return str_replace(resource_path('views/'), '', $file->getPathname());
                });

            return [
                'status' => 'success',
                'message' => 'Vues de l\'application valides',
                'details' => [
                    'total_views' => $views->count(),
                    'views' => $views
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur des vues',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste les optimisations de l'application
     */
    private function testOptimization(): array
    {
        try {
            $results = [
                'cdn' => $this->testCdn(),
                'email' => $this->testEmailOptimization(),
                'assets' => $this->testAssetOptimization(),
            ];

            return [
                'status' => 'success',
                'message' => 'Tests d\'optimisation effectués',
                'details' => $results
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erreur des tests d\'optimisation',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Teste la configuration CDN
     */
    private function testCdn(): array
    {
        return [
            'enabled' => Config::get('cdn.enabled', false),
            'url' => Config::get('cdn.url'),
            'key' => Config::get('cdn.key') ? 'présent' : 'manquant',
            'secret' => Config::get('cdn.secret') ? 'présent' : 'manquant',
        ];
    }

    /**
     * Teste l'optimisation des emails
     */
    private function testEmailOptimization(): array
    {
        return [
            'enabled' => Config::get('mail.optimization.enabled', false),
            'image' => Config::get('mail.optimization.image'),
            'html' => Config::get('mail.optimization.html'),
            'css' => Config::get('mail.optimization.css'),
        ];
    }

    /**
     * Teste l'optimisation des assets
     */
    private function testAssetOptimization(): array
    {
        return [
            'public_path' => public_path(),
            'mix_manifest' => File::exists(public_path('mix-manifest.json')),
            'vite_manifest' => File::exists(public_path('build/manifest.json')),
        ];
    }
} 