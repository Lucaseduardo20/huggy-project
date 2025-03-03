<?php

namespace App\Webhooks;

use App\Data\ClientData;
use App\Models\Client;
use App\Models\User;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;


class HuggyWebhook
{

    public function __construct(
        protected ClientRepository $clientRepository
    ) {}

    public function createClient(Request $request)
    {
        $data = $request->all();

        Client::updateOrCreate(
            ['email' => $data['email']],
            [
                'user_id' => User::query()->first()->id,
                'name'     => $data['name'],
                'phone' => $data['phone'] ?? null,
                'city'   => $data['city'] ?? null,
                'state'   => $data['state'] ?? null,
                'birthday'    => convertDateFormat($data['birthDate']) ?? null,
            ]
        );

        logger()->info('Novo contato recebido da Huggy', $data);

        return response()->json(['message' => 'Webhook processado com sucesso'], 200);
    }
}
