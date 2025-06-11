<?php

namespace Tests\Performance;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Appartement;
use App\Models\RelChauf;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelGaz;
use App\Models\RelElec;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DatabasePerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected $results = [];

    /** @test */
    public function it_measures_database_query_performance()
    {
        // Création de données de test
        $clients = Client::factory()->count(100)->create();
        foreach ($clients as $client) {
            Appartement::factory()->count(3)->create([
                'Codecli' => $client->Codecli
            ]);
        }

        // Test de performance des requêtes avec jointures
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $results = Client::with(['appartements', 'relChaufs', 'relEauCs'])
            ->where('Codecli', $clients->first()->Codecli)
            ->first();

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['eager_loading'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true)
        ];

        $this->assertLessThan(200, $duration, 'Le chargement eager prend trop de temps');
        $this->assertLessThan(5, count($queries), 'Trop de requêtes SQL exécutées');

        // Test de performance des requêtes avec filtres
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $results = RelChauf::where('Codecli', $clients->first()->Codecli)
            ->whereBetween('date', [now()->subMonths(6), now()])
            ->orderBy('date', 'desc')
            ->get();

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['filtered_queries'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true)
        ];

        $this->assertLessThan(150, $duration, 'Les requêtes filtrées prennent trop de temps');
        $this->assertLessThan(3, count($queries), 'Trop de requêtes SQL exécutées');

        // Test de performance des requêtes agrégées
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $results = RelChauf::where('Codecli', $clients->first()->Codecli)
            ->select('Codecli', DB::raw('AVG(valeur) as moyenne'), DB::raw('MAX(valeur) as maximum'))
            ->groupBy('Codecli')
            ->get();

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['aggregated_queries'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true)
        ];

        $this->assertLessThan(100, $duration, 'Les requêtes agrégées prennent trop de temps');
        $this->assertLessThan(2, count($queries), 'Trop de requêtes SQL exécutées');
    }

    /** @test */
    public function it_measures_batch_insert_performance()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        // Test d'insertion par lots
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $releves = [];
        for ($i = 0; $i < 1000; $i++) {
            $releves[] = [
                'Codecli' => $client->Codecli,
                'refApp' => $appartement->id,
                'date' => now()->format('Y-m-d'),
                'valeur' => rand(0, 1000),
                'commentaire' => 'Test batch'
            ];
        }

        RelChauf::insert($releves);

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['batch_insert'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true)
        ];

        $this->assertLessThan(1000, $duration, 'L\'insertion par lots prend trop de temps');
        $this->assertLessThan(2, count($queries), 'Trop de requêtes SQL exécutées');
    }

    /** @test */
    public function it_measures_cache_performance()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        // Test sans cache
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $results = Client::with(['appartements'])
            ->where('Codecli', $client->Codecli)
            ->first();

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['without_cache'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true)
        ];

        // Test avec cache
        Cache::flush();
        $start = microtime(true);
        $queries = DB::getQueryLog();

        $results = Cache::remember("client.{$client->Codecli}", 60, function () use ($client) {
            return Client::with(['appartements'])
                ->where('Codecli', $client->Codecli)
                ->first();
        });

        $end = microtime(true);
        $duration = ($end - $start) * 1000;
        $queries = array_slice(DB::getQueryLog(), count($queries));

        $this->results['with_cache'] = [
            'duration' => $duration,
            'queries' => count($queries),
            'memory' => memory_get_peak_usage(true)
        ];

        $this->assertLessThan($this->results['without_cache']['duration'], $duration, 'Le cache ne semble pas améliorer les performances');
    }

    protected function tearDown(): void
    {
        // Affichage des résultats de performance
        $this->info('Résultats des tests de performance de la base de données :');
        foreach ($this->results as $test => $metrics) {
            $this->info("\nTest : {$test}");
            $this->info("Durée : {$metrics['duration']}ms");
            $this->info("Requêtes SQL : {$metrics['queries']}");
            $this->info("Mémoire utilisée : " . round($metrics['memory'] / 1024 / 1024, 2) . "MB");
        }

        parent::tearDown();
    }
} 