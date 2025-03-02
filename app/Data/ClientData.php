<?php

namespace App\Data;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Max;

class ClientData extends Data
{
    public function __construct(
        public readonly ?int $id,

        public ?string $avatar,

        public ?int $user_id,

        #[Required, StringType, Max(100)]
        public readonly string $name,

        #[Nullable, Email, Unique('clients', 'email')]
        public readonly ?string $email,

        #[Nullable, StringType, Max(20)]
        public readonly ?string $phone,

        #[Nullable, StringType, Max(50)]
        public readonly ?string $state,

        #[Nullable, StringType, Max(50)]
        public readonly ?string $city,

        #[Nullable, Date]
        public readonly ?string $birthday,

        #[Nullable, StringType]
        public readonly ?string $address
    ) {
    }

    /**
     *
     * @param Client $client
     * @return self
     */
    public static function fromClient(Client $client): self
    {
        return new self(
            id: $client->id,
            avatar: $client->avatar,
            user_id: $client->user_id,
            name: $client->name,
            email: $client->email,
            phone: $client->f_phone,
            state: $client->state,
            city: $client->city,
            birthday: $client->f_birthday,
            address: $client->address
        );
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            avatar: null,
            user_id: Auth::id(),
            name: $data['name'],
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            state: $data['state'] ?? null,
            city: $data['city'] ?? null,
            birthday: convertDateFormat($data['birthday']) ?? null,
            address: $data['address'] ?? null
        );
    }
}
