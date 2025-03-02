<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'birthday',
        'state',
        'city',
        'address',
    ];

    public function fPhone(): Attribute
    {
        return Attribute::make(
            get: fn () => formatPhoneNumber($this->phone)
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
