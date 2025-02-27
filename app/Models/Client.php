<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'huggy_id',
    ];

    public function fPhone(): Attribute
    {
        return Attribute::make(
            get: formatPhoneNumber($this->phone)
        );
    }


}
