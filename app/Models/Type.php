<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public function scopeOfConventionStatus(Builder $query): void
    {
        $query->where('typeable_type', Convention::class.'.type');
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class, 'family_situation_id');
    }
}
