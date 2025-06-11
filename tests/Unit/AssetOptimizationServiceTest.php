<?php

namespace Tests\Unit;

use App\Services\AssetOptimizationService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Tests\TestCase;

class AssetOptimizationServiceTest extends TestCase
{
    private AssetOptimizationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        
        // Configure les paramètres de test
        Config::set('asset-optimization.enabled', true);
        Config::set('asset-optimization.image', [
            'max_width' => 800,
            'max_height' => 600,
            'quality' => 80,
            'format' => 'jpg',
            'driver' => 'gd'
        ]);
        Config::set('asset-optimization.css', [
            'minify' => true,
            'remove_comments' => true,
            'remove_last_semicolon' => true
        ]);
        Config::set('asset-optimization.js', [
            'minify' => true,
            'remove_comments' => true,
            'remove_last_semicolon' => true
        ]);
        Config::set('asset-optimization.html', [
            'minify' => true,
            'remove_comments' => true,
            'remove_attributes' => true
        ]);
        Config::set('asset-optimization.output', [
            'directory' => 'optimized',
            'preserve_structure' => true
        ]);

        $this->service = app(AssetOptimizationService::class);
    }

    public function test_optimize_image()
    {
        // Crée un fichier image de test avec un contenu simulé
        $imagePath = 'test.jpg';
        Storage::put($imagePath, str_repeat('0', 1000));

        $this->mock(Image::class, function ($mock) {
            $mock->shouldReceive('fit')
                ->once()
                ->with(Manipulations::FIT_CONTAIN, 800, 600)
                ->andReturnSelf();
            
            $mock->shouldReceive('quality')
                ->once()
                ->with(80)
                ->andReturnSelf();
            
            $mock->shouldReceive('save')
                ->once()
                ->andReturn(true);
        });

        $optimizedPath = $this->service->optimizeImage($imagePath);

        $this->assertStringStartsWith('optimized/', $optimizedPath);
        $this->assertTrue(Storage::exists($optimizedPath));
    }

    public function test_optimize_css()
    {
        $css = "
            /* Commentaire */
            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
            }
        ";

        $optimized = $this->service->optimizeCss($css);

        $this->assertStringNotContainsString('/* Commentaire */', $optimized);
        $this->assertStringNotContainsString("\n", $optimized);
        $this->assertStringNotContainsString('  ', $optimized);
    }

    public function test_optimize_js()
    {
        $js = "
            // Commentaire en ligne
            /* Commentaire en bloc */
            function test() {
                console.log('test');
                return true;
            }
        ";

        $optimized = $this->service->optimizeJs($js);

        $this->assertStringNotContainsString('// Commentaire en ligne', $optimized);
        $this->assertStringNotContainsString('/* Commentaire en bloc */', $optimized);
        $this->assertStringNotContainsString("\n", $optimized);
        $this->assertStringNotContainsString('  ', $optimized);
    }

    public function test_optimize_html()
    {
        $html = "
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Test</title>
                    <style>
                        body { margin: 0; }
                    </style>
                </head>
                <body>
                    <!-- Commentaire HTML -->
                    <div class='container' style='padding: 20px;'>
                        <h1>Test</h1>
                    </div>
                </body>
            </html>
        ";

        $optimized = $this->service->optimizeHtml($html);

        $this->assertStringNotContainsString('<!-- Commentaire HTML -->', $optimized);
        $this->assertStringNotContainsString("\n", $optimized);
        $this->assertStringNotContainsString('  ', $optimized);
    }

    public function test_is_optimized()
    {
        $this->assertTrue($this->service->isOptimized('optimized/test.jpg'));
        $this->assertFalse($this->service->isOptimized('test.jpg'));
    }

    public function test_optimize_directory()
    {
        // Crée des fichiers de test
        Storage::put('test.jpg', str_repeat('0', 1000));
        Storage::put('style.css', 'body { margin: 0; }');
        Storage::put('script.js', 'console.log("test");');
        Storage::put('index.html', '<div>Test</div>');

        $this->mock(Image::class, function ($mock) {
            $mock->shouldReceive('fit')
                ->once()
                ->with(Manipulations::FIT_CONTAIN, 800, 600)
                ->andReturnSelf();
            
            $mock->shouldReceive('quality')
                ->once()
                ->with(80)
                ->andReturnSelf();
            
            $mock->shouldReceive('save')
                ->once()
                ->andReturn(true);
        });

        $results = $this->service->optimizeDirectory('public');

        $this->assertArrayHasKey('success', $results);
        $this->assertArrayHasKey('failed', $results);
        $this->assertCount(4, $results['success']);
        $this->assertEmpty($results['failed']);

        foreach ($results['success'] as $result) {
            $this->assertStringStartsWith('optimized/', $result['optimized']);
            $this->assertTrue(Storage::exists($result['optimized']));
        }
    }

    public function test_optimize_directory_with_custom_options()
    {
        Storage::put('test.jpg', str_repeat('0', 1000));

        $options = [
            'max_width' => 1200,
            'max_height' => 800,
            'quality' => 90,
            'format' => 'png'
        ];

        $this->mock(Image::class, function ($mock) use ($options) {
            $mock->shouldReceive('fit')
                ->once()
                ->with(Manipulations::FIT_CONTAIN, $options['max_width'], $options['max_height'])
                ->andReturnSelf();
            
            $mock->shouldReceive('quality')
                ->once()
                ->with($options['quality'])
                ->andReturnSelf();
            
            $mock->shouldReceive('save')
                ->once()
                ->andReturn(true);
        });

        $results = $this->service->optimizeDirectory('public', $options);

        $this->assertArrayHasKey('success', $results);
        $this->assertArrayHasKey('failed', $results);
        $this->assertCount(1, $results['success']);
        $this->assertEmpty($results['failed']);

        $optimizedPath = $results['success'][0]['optimized'];
        $this->assertStringEndsWith('.png', $optimizedPath);
    }

    public function test_optimize_directory_when_disabled()
    {
        Config::set('asset-optimization.enabled', false);

        $results = $this->service->optimizeDirectory('public');

        $this->assertArrayHasKey('success', $results);
        $this->assertArrayHasKey('failed', $results);
        $this->assertEmpty($results['success']);
        $this->assertCount(1, $results['failed']);
        $this->assertEquals('L\'optimisation des assets est désactivée', $results['failed'][0]['error']);
    }
} 