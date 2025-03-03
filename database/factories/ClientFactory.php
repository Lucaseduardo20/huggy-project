<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'user_id'  => 1,
            'name'     => $this->faker->name(),
            'email'    => $this->faker->unique()->safeEmail(),
            'phone'    => $this->faker->phoneNumber(),
            'address'  => $this->faker->streetAddress(),
            'birthday' => convertDateFormat($this->faker->date('d/m/Y')),
            'city'     => $this->faker->city(),
            'state'    => $this->faker->stateAbbr(),
        ];
    }
}
