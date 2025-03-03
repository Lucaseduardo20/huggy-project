<?php

namespace App\Listeners;

use App\Events\StoreClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class SendClientToHuggy implements ShouldQueue
{
    public function handle(StoreClient $event)
    {
        $client = $event->client;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . auth()->user()->access_token,
            'Content-Type'  => 'application/json',
        ])->post('https://api.huggy.app/v3/contacts', [
            'name'      => $client->name,
            'email'     => $client->email,
            'phone'     => $client->phone,
            'city'      => $client->city,
            'state'     => $client->state,
            'photo'   => $client->avatar,
            'birthDate'       => $client->birthday,
        ]);

        if (!$response->successful()) {
            logger()->error('Erro ao enviar cliente para Huggy', ['response' => $response->body()]);
        }
    }
}

