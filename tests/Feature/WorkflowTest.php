<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Appartement;
use App\Models\RelChauf;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelGaz;
use App\Models\RelElec;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class WorkflowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_complete_full_reading_workflow()
    {
        // 1. Création du client et de l'appartement
        $client = Client::factory()->create([
            'Codecli' => 'TEST123',
            'nom' => 'Test Client'
        ]);

        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        // 2. Récupération des données client
        $response = $this->getJson("/decompte/saisieClientAjax?codeCli=TEST123");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'Codecli' => 'TEST123',
                    'nom' => 'Test Client'
                ]
            ]);

        // 3. Récupération des paramètres de chauffage
        $response = $this->getJson("/decompte/saisieParamAjax", [
            'codeCli' => $client->Codecli,
            'type' => 'chauffage',
            'refApp' => $appartement->id
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'appartement',
                    'parametres'
                ]
            ]);

        // 4. Saisie des relevés de chauffage
        $chaufData = [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'date' => now()->format('Y-m-d'),
            'valeur' => 100,
            'commentaire' => 'Test chauffage'
        ];

        $response = $this->postJson("/decompte/storeChauf", $chaufData);
        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        // 5. Récupération des paramètres d'eau
        $response = $this->getJson("/decompte/saisieParamAjax", [
            'codeCli' => $client->Codecli,
            'type' => 'eau',
            'refApp' => $appartement->id
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'appartement',
                    'parametres'
                ]
            ]);

        // 6. Saisie des relevés d'eau
        $eauData = [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'date' => now()->format('Y-m-d'),
            'valeur' => 50,
            'commentaire' => 'Test eau'
        ];

        $response = $this->postJson("/decompte/storeEau", $eauData);
        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        // 7. Vérification des données en base
        $this->assertDatabaseHas('rel_chaufs', [
            'Codecli' => $client->Codecli,
            'refApp' => $appartement->id,
            'valeur' => 100
        ]);

        $this->assertDatabaseHas('rel_eau_cs', [
            'Codecli' => $client->Codecli,
            'refApp' => $appartement->id,
            'valeur' => 50
        ]);
    }

    /** @test */
    public function it_handles_errors_in_workflow()
    {
        // 1. Test avec un client inexistant
        $response = $this->getJson("/decompte/saisieClientAjax?codeCli=NONEXISTENT");
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Client non trouvé'
            ]);

        // 2. Test avec des données invalides
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        $invalidData = [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'date' => 'invalid-date',
            'valeur' => 'not-a-number',
            'commentaire' => 'Test invalid'
        ];

        $response = $this->postJson("/decompte/storeChauf", $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['date', 'valeur']);
    }

    /** @test */
    public function it_can_handle_batch_operations()
    {
        $client = Client::factory()->create();
        $appartements = Appartement::factory()->count(3)->create([
            'Codecli' => $client->Codecli
        ]);

        // Création de plusieurs relevés en une seule fois
        $releves = [];
        foreach ($appartements as $appartement) {
            $releves[] = [
                'codeCli' => $client->Codecli,
                'refApp' => $appartement->id,
                'date' => now()->format('Y-m-d'),
                'valeur' => $this->faker->numberBetween(0, 1000),
                'commentaire' => 'Test batch'
            ];
        }

        foreach ($releves as $releve) {
            $response = $this->postJson("/decompte/storeChauf", $releve);
            $response->assertStatus(200)
                ->assertJson(['success' => true]);
        }

        // Vérification que tous les relevés ont été créés
        foreach ($releves as $releve) {
            $this->assertDatabaseHas('rel_chaufs', [
                'Codecli' => $releve['codeCli'],
                'refApp' => $releve['refApp'],
                'valeur' => $releve['valeur']
            ]);
        }
    }
} 