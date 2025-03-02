<?php

namespace App\Services;

namespace App\Services;

use App\Jobs\SendWelcomeEmailJob;
use App\Repositories\ClientRepository;
use App\Data\ClientData;
use App\Models\Client;
use App\Data\ClientResponseData;
use Carbon\Carbon;

class ClientService
{
    public function __construct(
        protected ClientRepository $clientRepository
    ) {}

    public function getAllClients(): array
    {
        return array_map(
            fn(Client $client) => ClientData::fromClient($client),
            $this->clientRepository->getAll()->all()
        );
    }

    public function getClientById(int $id): ?ClientResponseData
    {
        $client = $this->clientRepository->findById($id);
        return $client ? ClientResponseData::fromClient($client) : null;
    }

    public function createClient(ClientData $clientDTO): ClientResponseData
    {
        $client = $this->clientRepository->create($clientDTO->toArray());
        SendWelcomeEmailJob::dispatch($client)->delay(Carbon::now()->addMinutes(30));
        return ClientResponseData::fromClient($client);
    }

    public function updateClient(int $id, ClientData $clientDTO): ?ClientResponseData
    {
        $client = $this->clientRepository->findById($id);
        if (!$client) {
            return null;
        }

        $updatedClient = $this->clientRepository->update($client, $clientDTO->toArray());
        return ClientResponseData::fromClient($updatedClient);
    }

    public function deleteClient(int $id): bool
    {
        $client = $this->clientRepository->findById($id);
        if (!$client) {
            return false;
        }

        $this->clientRepository->delete($client);
        return true;
    }
}

