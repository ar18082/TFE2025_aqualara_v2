<?php

namespace App\Console\Commands;

use App\Services\ApplicationTestService;
use Illuminate\Console\Command;

class TestApplication extends Command
{
    protected $signature = 'app:test';
    protected $description = 'Exécute tous les tests de l\'application';

    public function handle(ApplicationTestService $testService)
    {
        $this->info('Démarrage des tests de l\'application...');
        
        $results = $testService->runAllTests();
        
        $this->displayResults($results);
    }

    private function displayResults(array $results): void
    {
        $this->newLine();
        $this->info('Résultats des tests :');
        $this->newLine();

        foreach ($results as $category => $result) {
            $this->line(str_repeat('-', 50));
            $this->info(ucfirst($category));
            
            if ($result['status'] === 'success') {
                $this->info('✓ ' . $result['message']);
            } else {
                $this->error('✗ ' . $result['message']);
                $this->error('  Erreur : ' . $result['error']);
            }

            if (isset($result['details'])) {
                $this->line('  Détails :');
                $this->displayDetails($result['details'], 2);
            }
        }

        $this->newLine();
        $this->displaySummary($results);
    }

    private function displayDetails(array $details, int $indent = 0): void
    {
        foreach ($details as $key => $value) {
            $prefix = str_repeat('  ', $indent);
            
            if (is_array($value)) {
                $this->line($prefix . $key . ' :');
                $this->displayDetails($value, $indent + 1);
            } else {
                $this->line($prefix . $key . ' : ' . $value);
            }
        }
    }

    private function displaySummary(array $results): void
    {
        $total = count($results);
        $success = collect($results)->where('status', 'success')->count();
        $errors = $total - $success;

        $this->info('Résumé :');
        $this->line("  Total des tests : {$total}");
        $this->info("  Tests réussis : {$success}");
        $this->error("  Tests échoués : {$errors}");
    }
} 