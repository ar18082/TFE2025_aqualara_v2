<?php

namespace Tests\Feature;

use App\Services\BenchmarkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DecompteControllerPerformanceTest extends TestCase
{
    use RefreshDatabase;

    private BenchmarkService $benchmarkService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->benchmarkService = new BenchmarkService();
    }

    /**
     * Test les performances de saisieClientAjax
     */
    public function test_saisie_client_ajax_performance()
    {
        $results = $this->benchmarkService->compareWithAndWithoutCache(
            'get',
            route('api.client.show', 'TEST001'),
            [],
            ['X-Requested-With' => 'XMLHttpRequest']
        );

        $this->assertGreaterThan(0, $results['improvement']['time']);
        $this->assertGreaterThan(0, $results['improvement']['memory']);

        Log::info($this->benchmarkService->generateReport($results));
    }

    /**
     * Test les performances de saisieParamAjax
     */
    public function test_saisie_param_ajax_performance()
    {
        $results = $this->benchmarkService->compareWithAndWithoutCache(
            'get',
            route('api.param.show', [
                'codeCli' => 'TEST001',
                'type' => 'chauffage',
                'refAppTR' => 'APP001'
            ]),
            [],
            ['X-Requested-With' => 'XMLHttpRequest']
        );

        $this->assertGreaterThan(0, $results['improvement']['time']);
        $this->assertGreaterThan(0, $results['improvement']['memory']);

        Log::info($this->benchmarkService->generateReport($results));
    }

    /**
     * Test les performances de saisieRelAjax
     */
    public function test_saisie_rel_ajax_performance()
    {
        $results = $this->benchmarkService->compareWithAndWithoutCache(
            'get',
            route('api.rel.show', [
                'codeCli' => 'TEST001',
                'refAppTR' => 'APP001',
                'type' => 'chauffage',
                'typeRel' => 'VISU'
            ]),
            [],
            ['X-Requested-With' => 'XMLHttpRequest']
        );

        $this->assertGreaterThan(0, $results['improvement']['time']);
        $this->assertGreaterThan(0, $results['improvement']['memory']);

        Log::info($this->benchmarkService->generateReport($results));
    }

    /**
     * Test les performances du batch processing
     */
    public function test_batch_processing_performance()
    {
        $requests = [
            [
                'method' => 'get',
                'url' => route('api.client.show', 'TEST001'),
                'data' => [],
                'headers' => ['X-Requested-With' => 'XMLHttpRequest']
            ],
            [
                'method' => 'get',
                'url' => route('api.param.show', [
                    'codeCli' => 'TEST001',
                    'type' => 'chauffage',
                    'refAppTR' => 'APP001'
                ]),
                'data' => [],
                'headers' => ['X-Requested-With' => 'XMLHttpRequest']
            ],
            [
                'method' => 'get',
                'url' => route('api.rel.show', [
                    'codeCli' => 'TEST001',
                    'refAppTR' => 'APP001',
                    'type' => 'chauffage',
                    'typeRel' => 'VISU'
                ]),
                'data' => [],
                'headers' => ['X-Requested-With' => 'XMLHttpRequest']
            ]
        ];

        $start = microtime(true);
        $memoryStart = memory_get_usage();

        foreach ($requests as $request) {
            $this->benchmarkService->benchmarkRequest(
                $request['method'],
                $request['url'],
                $request['data'],
                $request['headers']
            );
        }

        $end = microtime(true);
        $memoryEnd = memory_get_usage();

        $totalTime = ($end - $start) * 1000;
        $totalMemory = $memoryEnd - $memoryStart;

        Log::info("Performance du batch processing:");
        Log::info("Temps total: {$totalTime}ms");
        Log::info("Mémoire totale: {$totalMemory} octets");

        $this->assertLessThan(5000, $totalTime); // Moins de 5 secondes
        $this->assertLessThan(50 * 1024 * 1024, $totalMemory); // Moins de 50MB
    }
} 