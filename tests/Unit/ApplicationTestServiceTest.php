<?php

namespace Tests\Unit;

use App\Services\ApplicationTestService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ApplicationTestServiceTest extends TestCase
{
    private ApplicationTestService $testService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testService = new ApplicationTestService();
    }

    public function test_database_connection()
    {
        $result = $this->testService->testDatabase();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('driver', $result['details']);
        $this->assertArrayHasKey('database', $result['details']);
    }

    public function test_cache_system()
    {
        $result = $this->testService->testCache();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('driver', $result['details']);
        $this->assertArrayHasKey('value', $result['details']);
    }

    public function test_storage_system()
    {
        $result = $this->testService->testStorage();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('driver', $result['details']);
        $this->assertArrayHasKey('exists', $result['details']);
        $this->assertArrayHasKey('content', $result['details']);
    }

    public function test_mail_system()
    {
        Mail::fake();
        
        $result = $this->testService->testMail();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('driver', $result['details']);
        $this->assertArrayHasKey('from', $result['details']);
        
        Mail::assertSent(\Illuminate\Mail\Message::class);
    }

    public function test_queue_system()
    {
        Queue::fake();
        
        $result = $this->testService->testQueue();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('driver', $result['details']);
        $this->assertArrayHasKey('connection', $result['details']);
        
        Queue::assertPushed(\Illuminate\Foundation\Bus\Dispatchable::class);
    }

    public function test_logging_system()
    {
        Log::shouldReceive('info')
            ->once()
            ->andReturn(true);
            
        $result = $this->testService->testLogging();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('channel', $result['details']);
        $this->assertArrayHasKey('test_message', $result['details']);
    }

    public function test_config_system()
    {
        $result = $this->testService->testConfig();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('app', $result['details']);
        $this->assertArrayHasKey('mail', $result['details']);
        $this->assertArrayHasKey('queue', $result['details']);
        $this->assertArrayHasKey('cache', $result['details']);
    }

    public function test_routes_system()
    {
        Route::get('/test', function() {})->name('test');
        
        $result = $this->testService->testRoutes();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('total_routes', $result['details']);
        $this->assertArrayHasKey('routes', $result['details']);
    }

    public function test_views_system()
    {
        $result = $this->testService->testViews();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('total_views', $result['details']);
        $this->assertArrayHasKey('views', $result['details']);
    }

    public function test_optimization_system()
    {
        $result = $this->testService->testOptimization();
        
        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('cdn', $result['details']);
        $this->assertArrayHasKey('email', $result['details']);
        $this->assertArrayHasKey('assets', $result['details']);
    }
} 