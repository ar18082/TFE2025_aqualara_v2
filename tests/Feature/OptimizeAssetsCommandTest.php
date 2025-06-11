<?php

namespace Tests\Feature;

use App\Services\AssetOptimizationService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class OptimizeAssetsCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_command_optimizes_images()
    {
        // Crée un fichier image de test
        $imagePath = 'test.jpg';
        Storage::put($imagePath, file_get_contents(base_path('tests/fixtures/test.jpg')));

        $this->mock(AssetOptimizationService::class, function ($mock) {
            $mock->shouldReceive('optimizeDirectory')
                ->once()
                ->with('public', [
                    'max_width' => 800,
                    'max_height' => 600,
                    'quality' => 80,
                    'format' => 'jpg'
                ])
                ->andReturn([
                    'success' => [
                        [
                            'original' => 'test.jpg',
                            'optimized' => 'optimized/test.jpg'
                        ]
                    ],
                    'failed' => []
                ]);
        });

        $this->artisan('assets:optimize')
            ->assertExitCode(0)
            ->expectsOutput('Démarrage de l\'optimisation des assets dans le dossier public...')
            ->expectsOutput('✓ Assets optimisés avec succès :')
            ->expectsOutput('  - test.jpg -> optimized/test.jpg');
    }

    public function test_command_with_custom_options()
    {
        $this->mock(AssetOptimizationService::class, function ($mock) {
            $mock->shouldReceive('optimizeDirectory')
                ->once()
                ->with('public', [
                    'max_width' => 1200,
                    'max_height' => 800,
                    'quality' => 90,
                    'format' => 'png'
                ])
                ->andReturn([
                    'success' => [],
                    'failed' => []
                ]);
        });

        $this->artisan('assets:optimize', [
            '--max-width' => 1200,
            '--max-height' => 800,
            '--quality' => 90,
            '--format' => 'png'
        ])->assertExitCode(0);
    }

    public function test_command_with_custom_directory()
    {
        $this->mock(AssetOptimizationService::class, function ($mock) {
            $mock->shouldReceive('optimizeDirectory')
                ->once()
                ->with('custom/directory', [
                    'max_width' => 800,
                    'max_height' => 600,
                    'quality' => 80,
                    'format' => 'jpg'
                ])
                ->andReturn([
                    'success' => [],
                    'failed' => []
                ]);
        });

        $this->artisan('assets:optimize', ['custom/directory'])
            ->assertExitCode(0);
    }

    public function test_command_with_failures()
    {
        $this->mock(AssetOptimizationService::class, function ($mock) {
            $mock->shouldReceive('optimizeDirectory')
                ->once()
                ->andReturn([
                    'success' => [],
                    'failed' => [
                        [
                            'path' => 'failed.jpg',
                            'error' => 'Image too large'
                        ]
                    ]
                ]);
        });

        $this->artisan('assets:optimize')
            ->assertExitCode(0)
            ->expectsOutput('✗ Échecs de l\'optimisation :')
            ->expectsOutput('  - failed.jpg : Image too large');
    }

    public function test_command_summary()
    {
        $this->mock(AssetOptimizationService::class, function ($mock) {
            $mock->shouldReceive('optimizeDirectory')
                ->once()
                ->andReturn([
                    'success' => [
                        ['original' => 'test1.jpg', 'optimized' => 'optimized/test1.jpg'],
                        ['original' => 'test2.jpg', 'optimized' => 'optimized/test2.jpg']
                    ],
                    'failed' => [
                        ['path' => 'test3.jpg', 'error' => 'Error']
                    ]
                ]);
        });

        $this->artisan('assets:optimize')
            ->assertExitCode(0)
            ->expectsOutput('Résumé :')
            ->expectsOutput('  Total des assets : 3')
            ->expectsOutput('  Assets optimisés : 2')
            ->expectsOutput('  Échecs : 1');
    }
} 