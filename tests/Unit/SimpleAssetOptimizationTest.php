<?php

namespace Tests\Unit;

use App\Services\AssetOptimizationService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class SimpleAssetOptimizationTest extends TestCase
{
    private AssetOptimizationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configuration minimale pour les tests
        Config::set('asset-optimization.enabled', true);
        Config::set('asset-optimization.output.directory', 'optimized');
        
        $this->service = new AssetOptimizationService();
    }

    public function test_is_optimized()
    {
        $this->assertTrue($this->service->isOptimized('optimized/test.jpg'));
        $this->assertFalse($this->service->isOptimized('test.jpg'));
    }

    public function test_optimize_css()
    {
        $css = "body { margin: 0; }";
        $optimized = $this->service->optimizeCss($css);
        $this->assertIsString($optimized);
        $this->assertStringNotContainsString(' ', $optimized);
    }

    public function test_optimize_js()
    {
        $js = "console.log('test');";
        $optimized = $this->service->optimizeJs($js);
        $this->assertIsString($optimized);
        $this->assertStringNotContainsString(' ', $optimized);
    }

    public function test_optimize_html()
    {
        $html = "<div>Test</div>";
        $optimized = $this->service->optimizeHtml($html);
        $this->assertIsString($optimized);
        $this->assertStringNotContainsString(' ', $optimized);
    }
} 