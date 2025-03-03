<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreClient
{
    use Dispatchable, SerializesModels;

    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
