<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HuggyAuthController extends Controller
{
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
            return redirect('/')->withErrors(['auth' => 'Falha ao obter o token de acesso.']);
        }

        $tokens = $response->json();
        $accessToken = $tokens['access_token'];
        $refreshToken = $tokens['refresh_token'];

        $user = User::updateOrCreate(
            [
                'client_id' => env('HUGGY_CLIENT_ID'),
            ],
            [
                'client_id' => env('HUGGY_CLIENT_ID'),
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ]
        );

        Auth::login($user);

        $sanctumToken = $user->createToken('auth_token')->plainTextToken;

        return redirect()->to(env('NGROK_URL') . "/home?token={$sanctumToken}");

    }
}

