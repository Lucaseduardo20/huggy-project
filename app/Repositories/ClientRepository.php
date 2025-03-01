<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository
{
    public function getAll(): Collection
    {
        return Client::all();
    }

    public function findById(int $id): ?Client
    {
        return Client::find($id);
    }

    public function findByHuggyId(string $huggyId): ?Client
    {
        return Client::where('huggy_id', $huggyId)->first();
    }

    public function create(array $data): Client
    {
//        $client = new Client();
//        $client->name = $data['name'];
//        $client->email = $data['email'];
//        $client->phone = $data['phone'];
//        $client->birthday = $data['birthday'];
//        $client->state = $data['state'];
//        $client->city = $data['city'];
        return Client::create($data);
    }

    public function update(Client $client, array $data): Client
    {
        $client->update($data);
        return $client;
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}

