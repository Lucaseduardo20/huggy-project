<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getClientByAge()
    {
        return auth()->user()->clients()
            ->selectRaw('
            CASE
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 0 AND 19 THEN "0-19"
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 20 AND 29 THEN "20-29"
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 30 AND 39 THEN "30-39"
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 40 AND 49 THEN "40-49"
                WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 50 AND 59 THEN "50-59"
                ELSE "60+"
            END AS age_group,
            COUNT(*) AS total
        ')
            ->whereNotNull('birthday')
            ->groupBy('age_group')
            ->orderByRaw("MIN(TIMESTAMPDIFF(YEAR, birthday, CURDATE()))")
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
