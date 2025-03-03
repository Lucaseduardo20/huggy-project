<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, HasFactory;
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

    public function avatar(): Attribute
    {
        return Attribute::make(
            get: function () {
                $names = explode(' ', trim($this->name));

                if (count($names) === 1) {
                    return strtoupper(mb_substr($names[0], 0, 2));
                }

                $firstInitial = strtoupper(mb_substr($names[0], 0, 1));
                $lastInitial = strtoupper(mb_substr(end($names), 0, 1));

                return $firstInitial . $lastInitial;
            }
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
