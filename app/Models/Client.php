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
        'user_id'
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
