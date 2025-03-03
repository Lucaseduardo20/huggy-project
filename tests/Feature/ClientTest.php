<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    protected ClientService $clientService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::query()->first());
        $this->clientService = $this->mock(ClientService::class);
    }

    public function index_returns_clients_test(): void
    {
        $clients = Client::factory()->count(3)->create();

        $this->clientService->shouldReceive('getAllClients')->once()->andReturn($clients);

        $response = $this->getJson(route('clients.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function show_returns_client_when_found_test(): void
    {
        $client = Client::factory()->create();

        $this->clientService->shouldReceive('getClientById')->with($client->id)->once()->andReturn($client);

        $response = $this->getJson(route('clients.show', $client->id));

        $response->assertStatus(200)
            ->assertJson(['id' => $client->id]);
    }

    public function show_returns_404_when_client_not_found_test(): void
    {
        $this->clientService->shouldReceive('getClientById')->once()->andReturn(null);

        $response = $this->getJson(route('clients.show', 999));

        $response->assertStatus(404);
    }

    public function store_creates_new_client_test(): void
    {
        $clientData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'city' => 'Some City',
            'state' => 'Some State',
            'birthday' => '1990-01-01'
        ];

        $this->clientService->shouldReceive('createClient')->once()->andReturn($clientData);

        $response = $this->postJson(route('clients.store'), $clientData);

        $response->assertStatus(201)
            ->assertJson($clientData);
    }

    public function update_modifies_existing_client_test(): void
    {
        $client = Client::factory()->create();
        $updatedData = ['name' => 'Updated Name'];

        $this->clientService->shouldReceive('updateClient')->with($client->id, $updatedData)->once()->andReturn(array_merge($client->toArray(), $updatedData));

        $response = $this->putJson(route('clients.update', $client->id), $updatedData);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Name']);
    }

    public function update_returns_404_when_client_not_found_test(): void
    {
        $this->clientService->shouldReceive('updateClient')->once()->andReturn(null);

        $response = $this->putJson(route('clients.update', 999), ['name' => 'Updated Name']);

        $response->assertStatus(404);
    }

    public function destroy_deletes_client_test(): void
    {
        $client = Client::factory()->create();

        $this->clientService->shouldReceive('deleteClient')->with($client->id)->once()->andReturn(true);

        $response = $this->deleteJson(route('clients.destroy', $client->id));

        $response->assertStatus(200)
            ->assertJson(['message' => 'Cliente excluído com sucesso']);
    }

    public function destroy_returns_404_when_client_not_found_test(): void
    {
        $this->clientService->shouldReceive('deleteClient')->once()->andReturn(false);

        $response = $this->deleteJson(route('clients.destroy', 999));

        $response->assertStatus(404);
    }
}
