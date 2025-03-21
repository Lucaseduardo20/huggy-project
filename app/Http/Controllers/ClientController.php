<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use App\Data\ClientData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        protected ClientService $clientService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->clientService->getAllClients());
    }

    public function show(int $id): JsonResponse
    {
        $client = $this->clientService->getClientById($id);
        return $client
            ? response()->json($client)
            : response()->json(['message' => 'Cliente não encontrado'], 404);
    }

    public function store(Request $request): JsonResponse
    {

        return response()->json(
            $this->clientService->createClient(ClientData::fromRequest($request->all())),
            201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $client = $this->clientService->updateClient($id,
            ClientData::fromRequest($request->all()));
        return $client
            ? response()->json($client)
            : response()->json(['message' => 'Cliente não encontrado'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->clientService->deleteClient($id)
            ? response()->json(['message' => 'Cliente excluído com sucesso'])
            : response()->json(['message' => 'Cliente não encontrado'], 404);
    }
}


