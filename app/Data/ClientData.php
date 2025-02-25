<?php

namespace App\Data;

use App\Models\Client;
use Spatie\LaravelData\Data;

class ClientData extends Data
{
    public function __construct(
        public ?int $id,

        #[Required, StringType]
        public string $name,

        #[Nullable, Email, Unique('clients', 'email')]
        public ?string $email,

        #[Nullable, StringType]
        public ?string $phone,

        #[Required, StringType, Unique('clients', 'huggy_id')]
        public string $huggy_id
    ) {}

    public static function fromClient(Client $client): self
    {
        return new self(
            id: $client->id,
            name: $client->name,
            email: $client->email,
            phone: $client->phone,
            huggy_id: $client->huggy_id
        );
    }
}
