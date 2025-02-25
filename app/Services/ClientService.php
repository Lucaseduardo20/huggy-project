<?php

namespace App\Services;

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Data\ClientData;
use App\Models\Client;

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

    public function getClientById(int $id): ?ClientData
    {
        $client = $this->clientRepository->findById($id);
        return $client ? ClientData::fromClient($client) : null;
    }

    public function createClient(ClientData $clientDTO): ClientData
    {
        $client = $this->clientRepository->create($clientDTO->toArray());
        return ClientData::fromClient($client);
    }

    public function updateClient(int $id, ClientData $clientDTO): ?ClientData
    {
        $client = $this->clientRepository->findById($id);
        if (!$client) {
            return null;
        }

        $updatedClient = $this->clientRepository->update($client, $clientDTO->toArray());
        return ClientData::fromClient($updatedClient);
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

