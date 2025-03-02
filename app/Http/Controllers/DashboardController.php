<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{

    public function __construct(
        protected DashboardService $service
    ) {}

    public function getDashboardData(): JsonResponse
    {
        $data = [
            'age' => $this->service->getClientByAge(),
            'city' => $this->service->getClientByCity(),
            'state' => $this->service->getClientByState()
        ];

        return response()->json($data, 200);
    }
}
