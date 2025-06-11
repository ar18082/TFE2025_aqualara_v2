<?php

namespace Tests\Feature;

use App\Services\ApplicationTestService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TestApplicationCommandTest extends TestCase
{
    public function test_command_execution()
    {
        $this->mock(ApplicationTestService::class, function ($mock) {
            $mock->shouldReceive('runAllTests')
                ->once()
                ->andReturn([
                    'database' => [
                        'status' => 'success',
                        'message' => 'Test database message',
                        'details' => ['test' => 'value']
                    ],
                    'cache' => [
                        'status' => 'success',
                        'message' => 'Test cache message',
                        'details' => ['test' => 'value']
                    ]
                ]);
        });

        $exitCode = Artisan::call('app:test');

        $this->assertEquals(0, $exitCode);
        $this->assertStringContainsString('Démarrage des tests de l\'application', Artisan::output());
        $this->assertStringContainsString('Test database message', Artisan::output());
        $this->assertStringContainsString('Test cache message', Artisan::output());
    }

    public function test_command_with_errors()
    {
        $this->mock(ApplicationTestService::class, function ($mock) {
            $mock->shouldReceive('runAllTests')
                ->once()
                ->andReturn([
                    'database' => [
                        'status' => 'error',
                        'message' => 'Database error',
                        'error' => 'Connection failed'
                    ],
                    'cache' => [
                        'status' => 'success',
                        'message' => 'Cache working',
                        'details' => ['test' => 'value']
                    ]
                ]);
        });

        $exitCode = Artisan::call('app:test');

        $this->assertEquals(1, $exitCode);
        $this->assertStringContainsString('Database error', Artisan::output());
        $this->assertStringContainsString('Connection failed', Artisan::output());
        $this->assertStringContainsString('Cache working', Artisan::output());
    }

    public function test_command_summary()
    {
        $this->mock(ApplicationTestService::class, function ($mock) {
            $mock->shouldReceive('runAllTests')
                ->once()
                ->andReturn([
                    'test1' => ['status' => 'success'],
                    'test2' => ['status' => 'success'],
                    'test3' => ['status' => 'error']
                ]);
        });

        Artisan::call('app:test');

        $output = Artisan::output();
        $this->assertStringContainsString('Total des tests : 3', $output);
        $this->assertStringContainsString('Tests réussis : 2', $output);
        $this->assertStringContainsString('Tests échoués : 1', $output);
    }
} 