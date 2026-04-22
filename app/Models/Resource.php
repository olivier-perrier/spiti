<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'periodicity',
        'beneficiary_id',
        'start_date',
        'end_date',
        'type',
        'amount',
        'comment',
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
}
