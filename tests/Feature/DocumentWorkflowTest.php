<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentWorkflowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('documents');
    }

    /** @test */
    public function it_can_upload_and_manage_documents()
    {
        // 1. Création du client
        $client = Client::factory()->create();

        // 2. Upload d'un document
        $file = UploadedFile::fake()->create('document.pdf', 100);
        $response = $this->postJson("/documents/upload", [
            'client_id' => $client->id,
            'document' => $file,
            'type' => 'contrat',
            'titre' => 'Test Document',
            'commentaire' => 'Test commentaire'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Document uploadé avec succès'
            ]);

        // 3. Vérification du document en base
        $this->assertDatabaseHas('documents', [
            'client_id' => $client->id,
            'type' => 'contrat',
            'titre' => 'Test Document'
        ]);

        // 4. Récupération des documents du client
        $response = $this->getJson("/documents/client/{$client->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'titre',
                        'type',
                        'date_creation'
                    ]
                ]
            ]);

        // 5. Suppression du document
        $document = Document::where('client_id', $client->id)->first();
        $response = $this->deleteJson("/documents/{$document->id}");
        
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Document supprimé avec succès'
            ]);

        // 6. Vérification de la suppression
        $this->assertDatabaseMissing('documents', [
            'id' => $document->id
        ]);
    }

    /** @test */
    public function it_validates_document_upload()
    {
        $client = Client::factory()->create();

        // Test avec un fichier trop grand
        $file = UploadedFile::fake()->create('document.pdf', 10000);
        $response = $this->postJson("/documents/upload", [
            'client_id' => $client->id,
            'document' => $file,
            'type' => 'contrat',
            'titre' => 'Test Document'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['document']);

        // Test avec un type de fichier non autorisé
        $file = UploadedFile::fake()->create('document.exe', 100);
        $response = $this->postJson("/documents/upload", [
            'client_id' => $client->id,
            'document' => $file,
            'type' => 'contrat',
            'titre' => 'Test Document'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['document']);
    }

    /** @test */
    public function it_can_update_document_metadata()
    {
        $client = Client::factory()->create();
        $document = Document::factory()->create([
            'client_id' => $client->id
        ]);

        $response = $this->putJson("/documents/{$document->id}", [
            'titre' => 'Document mis à jour',
            'type' => 'facture',
            'commentaire' => 'Nouveau commentaire'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Document mis à jour avec succès'
            ]);

        $this->assertDatabaseHas('documents', [
            'id' => $document->id,
            'titre' => 'Document mis à jour',
            'type' => 'facture',
            'commentaire' => 'Nouveau commentaire'
        ]);
    }

    /** @test */
    public function it_can_search_documents()
    {
        $client = Client::factory()->create();
        Document::factory()->count(3)->create([
            'client_id' => $client->id,
            'type' => 'contrat'
        ]);

        Document::factory()->count(2)->create([
            'client_id' => $client->id,
            'type' => 'facture'
        ]);

        // Recherche par type
        $response = $this->getJson("/documents/search", [
            'client_id' => $client->id,
            'type' => 'contrat'
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');

        // Recherche par titre
        $document = Document::where('client_id', $client->id)->first();
        $response = $this->getJson("/documents/search", [
            'client_id' => $client->id,
            'search' => $document->titre
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
} 