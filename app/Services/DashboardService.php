<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getClientByAge()
    {
        return auth()->user()->clients()
            ->selectRaw('FLOOR(age / 10) * 10 AS age_group, COUNT(*) AS total')
            ->whereNotNull('age')
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->get();
    }

    public function getClientByCity()
    {

        return auth()->user()->clients()
            ->select('city', DB::raw('COUNT(*) AS total'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('total')
            ->get();
    }

    public function getClientByState()
    {
        return auth()->user()->clients()
            ->select('state', DB::raw('COUNT(*) AS total'))
            ->whereNotNull('state')
            ->groupBy('state')
            ->orderByDesc('total')
            ->get();
    }
}
