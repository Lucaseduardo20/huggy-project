<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\TwiML;

class TwilioController extends Controller
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function makeCall(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
        ]);

        $from = env('TWILIO_PHONE_NUMBER');
        $to = $request->to;

        try {
            $call = $this->twilio->calls->create(
                $to,
                $from,
                [
                    'url' => route('twilio.voice-response')
                ]
            );

            return response()->json(['message' => 'Call initiated', 'call_sid' => $call->sid]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function voiceResponse()
    {
        $response = new \Twilio\TwiML();
        $response->say("Olá, esse é o teste de voip do Lucas!", ['voice' => 'alice']);
        return response($response)->header('Content-Type', 'text/xml');
    }
}
