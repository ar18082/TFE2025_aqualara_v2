<?php

namespace Tests\Performance;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Appartement;
use App\Models\RelChauf;
use App\Models\RelEauC;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AjaxPerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected $client;
    protected $appartement;
    protected $results = [];

    protected function setUp(): void
    {
        parent::setUp();
        
        // Création des données de test
        $this->client = Client::factory()->create();
        $this->appartement = Appartement::factory()->create([
            'Codecli' => $this->client->Codecli
        ]);

        // Création de données de test pour les relevés
        RelChauf::factory()->count(100)->create([
            'Codecli' => $this->client->Codecli,
            'refApp' => $this->appartement->id
        ]);

        RelEauC::factory()->count(100)->create([
            'Codecli' => $this->client->Codecli,
            'refApp' => $this->appartement->id
        ]);
    }

    /** @test */
    public function it_measures_client_data_retrieval_performance()
    {
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $response = $this->getJson("/decompte/saisieClientAjax?codeCli={$this->client->Codecli}");

        $end = microtime(true);
        $duration = ($end - $start) * 1000; // Conversion en millisecondes
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['client_data'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true),
            'cache_hits' => Cache::get('cache_hits', 0)
        ];

        $this->assertLessThan(100, $duration, 'La requête client prend trop de temps');
        $this->assertLessThan(3, count($queries), 'Trop de requêtes SQL exécutées');
    }

    /** @test */
    public function it_measures_heating_parameters_retrieval_performance()
    {
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $response = $this->getJson("/decompte/saisieParamAjax", [
            'codeCli' => $this->client->Codecli,
            'type' => 'chauffage',
            'refApp' => $this->appartement->id
        ]);

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['heating_params'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true),
            'cache_hits' => Cache::get('cache_hits', 0)
        ];

        $this->assertLessThan(150, $duration, 'La requête des paramètres de chauffage prend trop de temps');
        $this->assertLessThan(5, count($queries), 'Trop de requêtes SQL exécutées');
    }

    /** @test */
    public function it_measures_water_parameters_retrieval_performance()
    {
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $response = $this->getJson("/decompte/saisieParamAjax", [
            'codeCli' => $this->client->Codecli,
            'type' => 'eau',
            'refApp' => $this->appartement->id
        ]);

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['water_params'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true),
            'cache_hits' => Cache::get('cache_hits', 0)
        ];

        $this->assertLessThan(150, $duration, 'La requête des paramètres d\'eau prend trop de temps');
        $this->assertLessThan(5, count($queries), 'Trop de requêtes SQL exécutées');
    }

    /** @test */
    public function it_measures_batch_operations_performance()
    {
        $start = microtime(true);
        $queries = DB::getQueryLog();

        // Création de 10 relevés en une fois
        $releves = [];
        for ($i = 0; $i < 10; $i++) {
            $releves[] = [
                'codeCli' => $this->client->Codecli,
                'refApp' => $this->appartement->id,
                'date' => now()->format('Y-m-d'),
                'valeur' => rand(0, 1000),
                'commentaire' => 'Test batch'
            ];
        }

        foreach ($releves as $releve) {
            $this->postJson("/decompte/storeChauf", $releve);
        }

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['batch_operations'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true),
            'cache_hits' => Cache::get('cache_hits', 0)
        ];

        $this->assertLessThan(500, $duration, 'Les opérations par lots prennent trop de temps');
        $this->assertLessThan(20, count($queries), 'Trop de requêtes SQL exécutées');
    }

    protected function tearDown(): void
    {
        // Affichage des résultats de performance
        $this->info('Résultats des tests de performance :');
        foreach ($this->results as $test => $metrics) {
            $this->info("\nTest : {$test}");
            $this->info("Durée : {$metrics['duration']}ms");
            $this->info("Requêtes SQL : {$metrics['queries']}");
            $this->info("Mémoire utilisée : " . round($metrics['memory'] / 1024 / 1024, 2) . "MB");
            $this->info("Cache hits : {$metrics['cache_hits']}");
        }

        parent::tearDown();
    }
} 