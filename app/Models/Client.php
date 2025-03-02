<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
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

    public function fBirthday(): Attribute
    {
        return Attribute::make(
            get: fn () =>
                Carbon::parse($this->birthday)->format('d/m/Y')
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
