<?php

namespace App\Console\Commands;

use App\Services\AssetOptimizationService;
use Illuminate\Console\Command;

class OptimizeAssets extends Command
{
    /**
     * Le nom et la signature de la commande
     */
    protected $signature = 'assets:optimize {directory?} {--max-width=800} {--max-height=600} {--quality=80} {--format=jpg}';

    /**
     * La description de la commande
     */
    protected $description = 'Optimise tous les assets (images, CSS, JS, HTML) d\'un dossier';

    /**
     * Exécute la commande
     */
    public function handle(AssetOptimizationService $optimizationService)
    {
        $directory = $this->argument('directory') ?? 'public';
        $options = [
            'max_width' => $this->option('max-width'),
            'max_height' => $this->option('max-height'),
            'quality' => $this->option('quality'),
            'format' => $this->option('format'),
        ];

        $this->info("Démarrage de l'optimisation des assets dans le dossier {$directory}...");

        $results = $optimizationService->optimizeDirectory($directory, $options);

        $this->displayResults($results);
    }

    private function displayResults(array $results): void
    {
        $this->newLine();
        $this->info('Résultats de l\'optimisation :');
        $this->newLine();

        if (!empty($results['success'])) {
            $this->info('✓ Assets optimisés avec succès :');
            foreach ($results['success'] as $result) {
                $this->line("  - {$result['original']} -> {$result['optimized']}");
            }
        }

        if (!empty($results['failed'])) {
            $this->error('✗ Échecs de l\'optimisation :');
            foreach ($results['failed'] as $result) {
                $this->error("  - {$result['path']} : {$result['error']}");
            }
        }

        $this->newLine();
        $this->displaySummary($results);
    }

    private function displaySummary(array $results): void
    {
        $total = count($results['success']) + count($results['failed']);
        $success = count($results['success']);
        $failed = count($results['failed']);

        $this->info('Résumé :');
        $this->line("  Total des assets : {$total}");
        $this->info("  Assets optimisés : {$success}");
        $this->error("  Échecs : {$failed}");
    }
} 