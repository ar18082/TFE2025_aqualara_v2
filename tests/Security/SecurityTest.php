<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Appartement;
use App\Models\RelChauf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_protects_against_sql_injection()
    {
        // Création d'un client de test
        $client = Client::factory()->create();

        // Test d'injection SQL dans le code client
        $maliciousCode = "TEST123' OR '1'='1";
        $response = $this->getJson("/decompte/saisieClientAjax?codeCli=" . urlencode($maliciousCode));

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Client non trouvé'
            ]);

        // Vérification qu'aucune requête SQL malveillante n'a été exécutée
        $queries = DB::getQueryLog();
        foreach ($queries as $query) {
            $this->assertStringNotContainsString(
                "OR '1'='1",
                $query['query'],
                'Une injection SQL a été détectée'
            );
        }

        // Test d'injection SQL dans les paramètres de recherche
        $maliciousParams = [
            'codeCli' => $client->Codecli,
            'refApp' => "1' OR '1'='1",
            'type' => 'chauffage'
        ];

        $response = $this->getJson("/decompte/saisieParamAjax", $maliciousParams);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['refApp']);
    }

    /** @test */
    public function it_protects_against_xss_attacks()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        // Test d'injection XSS dans les commentaires
        $xssPayload = "<script>alert('xss')</script>";
        $response = $this->postJson("/decompte/storeChauf", [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'date' => now()->format('Y-m-d'),
            'valeur' => 100,
            'commentaire' => $xssPayload
        ]);

        $response->assertStatus(200);
        
        // Vérification que le script a été échappé
        $releve = RelChauf::latest()->first();
        $this->assertStringNotContainsString(
            '<script>',
            $releve->commentaire,
            'Le XSS n\'a pas été correctement échappé'
        );
    }

    /** @test */
    public function it_protects_against_csrf_attacks()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        // Désactivation de la protection CSRF pour ce test
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Tentative de requête sans token CSRF
        $response = $this->postJson("/decompte/storeChauf", [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'date' => now()->format('Y-m-d'),
            'valeur' => 100,
            'commentaire' => 'Test CSRF'
        ]);

        $response->assertStatus(419); // Token CSRF manquant
    }

    /** @test */
    public function it_protects_against_file_upload_attacks()
    {
        $client = Client::factory()->create();

        // Test d'upload de fichier malveillant
        $maliciousFile = new \Illuminate\Http\UploadedFile(
            base_path('tests/fixtures/malicious.php'),
            'malicious.php',
            'application/x-httpd-php',
            null,
            true
        );

        $response = $this->postJson("/documents/upload", [
            'client_id' => $client->id,
            'document' => $maliciousFile,
            'type' => 'contrat',
            'titre' => 'Test Upload'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['document']);
    }

    /** @test */
    public function it_protects_against_mass_assignment()
    {
        $client = Client::factory()->create();

        // Tentative de modification de champs protégés
        $response = $this->putJson("/clients/{$client->id}", [
            'id' => 999, // Tentative de modification de l'ID
            'created_at' => now(), // Tentative de modification de la date de création
            'Codecli' => 'NEW123',
            'nom' => 'Updated Name'
        ]);

        $response->assertStatus(200);

        // Vérification que les champs protégés n'ont pas été modifiés
        $updatedClient = Client::find($client->id);
        $this->assertEquals($client->id, $updatedClient->id);
        $this->assertEquals($client->created_at, $updatedClient->created_at);
        $this->assertEquals('NEW123', $updatedClient->Codecli);
        $this->assertEquals('Updated Name', $updatedClient->nom);
    }

    /** @test */
    public function it_protects_against_rate_limiting()
    {
        // Tentative de nombreuses requêtes en peu de temps
        for ($i = 0; $i < 60; $i++) {
            $response = $this->getJson("/decompte/saisieClientAjax?codeCli=TEST123");
        }

        $response->assertStatus(429)
            ->assertJson([
                'message' => 'Too many requests'
            ]);
    }
} 