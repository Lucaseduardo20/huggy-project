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
    public function clientByAge(): JsonResponse
    {
        return response()->json($this->service->getClientByAge());
    }

    public function clientByCity(): JsonResponse
    {
        return response()->json($this->service->getClientByCity());
    }
}
