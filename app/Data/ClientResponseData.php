<?php

namespace App\Data;

use App\Models\Client;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Max;

class ClientResponseData extends Data
{
    public function __construct(
        public readonly int $id,

        #[StringType, Max(100)]
        public readonly string $name,

        #[Nullable, Email]
        public readonly ?string $email,

        #[Nullable, StringType, Max(20)]
        public readonly ?string $phone
    ) {}

    public static function fromClient(Client $client): self
    {
        return new self(
            id: $client->id,
            name: $client->name,
            email: $client->email,
            phone: $client->phone
        );
    }
}

