<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
class DashboardService
{
    public function getClientByAge()
    {
        return auth()->user()->clients()
            ->selectRaw('FLOOR(age / 10) * 10 as age_group, COUNT(*) as total')
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->get();
    }

    public function getClientByCity()
    {
        return auth()->user()->clients()
            ->select('city', DB::raw('COUNT(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();
    }
}
