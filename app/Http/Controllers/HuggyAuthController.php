<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HuggyAuthController extends Controller
{
    public function redirectToHuggy()
    {
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
        if ($request->has('error')) {
            return redirect('/')->withErrors(['auth' => 'Erro na autenticação com Huggy.']);
        }

        $response = Http::post('https://auth.huggy.app/oauth/access_token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('HUGGY_CLIENT_ID'),
            'client_secret' => env('HUGGY_CLIENT_SECRET'),
            'redirect_uri' => env('HUGGY_REDIRECT_URI'),
            'code' => $request->code,
        ]);

        if ($response->failed()) {
            logger('deu pau no token' , ['response' => $response]);
            return redirect('/')->withErrors(['auth' => 'Falha ao obter o token de acesso.']);
        }

        $tokens = $response->json();
        $accessToken = $tokens['access_token'];
        $refreshToken = $tokens['refresh_token'];

        $user = User::updateOrCreate(
            [
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ]
        );


        Auth::login($user);
        dd('teóricamente deve ter criado usuário no banco e funcionou');

        return redirect('/dashboard');
    }
}

