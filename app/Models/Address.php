<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'city',
        'country',
        'postcode',
    ];

    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->street.' '.$this->postcode.' '.$this->city,
        );
    }
}
