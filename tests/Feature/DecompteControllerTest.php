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

class DecompteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_retrieve_client_data_via_ajax()
    {
        $client = Client::factory()->create([
            'Codecli' => 'TEST123',
            'nom' => 'Test Client',
            'rue' => '123 Test Street'
        ]);

        $response = $this->getJson("/decompte/saisieClientAjax?codeCli=TEST123");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'Codecli' => 'TEST123',
                    'nom' => 'Test Client',
                    'rue' => '123 Test Street'
                ]
            ]);
    }

    /** @test */
    public function it_returns_error_when_client_not_found()
    {
        $response = $this->getJson("/decompte/saisieClientAjax?codeCli=NONEXISTENT");

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Client non trouvé'
            ]);
    }

    /** @test */
    public function it_can_retrieve_heating_parameters()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

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
    }

    /** @test */
    public function it_can_retrieve_water_parameters()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

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
    }

    /** @test */
    public function it_can_retrieve_heating_relationships()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        $response = $this->getJson("/decompte/saisieRelAjax", [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'type' => 'chauffage',
            'typeRel' => 'appartement'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'relations'
                ]
            ]);
    }

    /** @test */
    public function it_can_retrieve_water_relationships()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        $response = $this->getJson("/decompte/saisieRelAjax", [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'type' => 'eau',
            'typeRel' => 'appartement'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'relations'
                ]
            ]);
    }

    /** @test */
    public function it_can_store_heating_data()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        $data = [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'date' => now()->format('Y-m-d'),
            'valeur' => 100,
            'commentaire' => 'Test comment'
        ];

        $response = $this->postJson("/decompte/storeChauf", $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('rel_chaufs', [
            'Codecli' => $client->Codecli,
            'refApp' => $appartement->id,
            'valeur' => 100
        ]);
    }

    /** @test */
    public function it_can_store_water_data()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        $data = [
            'codeCli' => $client->Codecli,
            'refApp' => $appartement->id,
            'date' => now()->format('Y-m-d'),
            'valeur' => 50,
            'commentaire' => 'Test comment'
        ];

        $response = $this->postJson("/decompte/storeEau", $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('rel_eau_cs', [
            'Codecli' => $client->Codecli,
            'refApp' => $appartement->id,
            'valeur' => 50
        ]);
    }
} 