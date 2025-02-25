<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HuggyAuthController extends Controller
{
    public function redirectToHuggy()
    {
        dd('bareu auqi');
        $query = http_build_query([
            'client_id' => env('HUGGY_CLIENT_ID'),
            'redirect_uri' => env('HUGGY_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'install_app read_agent_profile',
        ]);

        return redirect('https://auth.huggy.app/oauth/authorize?' . $query);
    }

    public function handleHuggyCallback(Request $request)
    {
        $response = Http::post('https://auth.huggy.app/oauth/access_token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('HUGGY_CLIENT_ID'),
            'client_secret' => env('HUGGY_CLIENT_SECRET'),
            'redirect_uri' => env('HUGGY_REDIRECT_URI'),
            'code' => $request->code,
        ]);

        $tokens = $response->json();

        session(['huggy_access_token' => $tokens['access_token']]);
        session(['huggy_refresh_token' => $tokens['refresh_token']]);

        return redirect('/dashboard');
    }
}
