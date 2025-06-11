<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Appartement;
use App\Models\Contact;
use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_find_client_by_code()
    {
        $client = Client::factory()->create([
            'Codecli' => 'TEST123'
        ]);

        $foundClient = Client::findByCode('TEST123');

        $this->assertNotNull($foundClient);
        $this->assertEquals($client->id, $foundClient->id);
    }

    /** @test */
    public function it_returns_null_when_client_not_found()
    {
        $foundClient = Client::findByCode('NONEXISTENT');

        $this->assertNull($foundClient);
    }

    /** @test */
    public function it_can_have_appartements()
    {
        $client = Client::factory()->create();
        $appartement = Appartement::factory()->create([
            'Codecli' => $client->Codecli
        ]);

        $this->assertTrue($client->appartements->contains($appartement));
    }

    /** @test */
    public function it_can_have_contacts()
    {
        $client = Client::factory()->create();
        $contact = Contact::factory()->create([
            'nom' => $client->gerant
        ]);

        $this->assertTrue($client->contacts->contains($contact));
    }

    /** @test */
    public function it_can_have_documents()
    {
        $client = Client::factory()->create();
        $document = Document::factory()->create([
            'client_id' => $client->id
        ]);

        $this->assertTrue($client->documents->contains($document));
    }

    /** @test */
    public function it_can_be_created_with_required_fields()
    {
        $clientData = [
            'Codecli' => 'TEST456',
            'nom' => 'Test Client',
            'rue' => '123 Test Street',
            'codePost' => '75000',
            'codepays' => 'FR',
            'tel' => '0123456789',
            'email' => 'test@example.com'
        ];

        $client = Client::create($clientData);

        $this->assertDatabaseHas('clients', $clientData);
        $this->assertInstanceOf(Client::class, $client);
    }
} 