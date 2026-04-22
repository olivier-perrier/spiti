<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Residence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dispositif_id',
        'elevator',
        'parking',
        'heating',
        'public_transport',
    ];

    public function dispositif(): BelongsTo
    {
        return $this->belongsTo(Dispositif::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class)->where('typeable_type', Residence::class);
    }

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }

    public function getTocAttribute()
    {
        if ($this->capacity) {
            return $this->lots()->withCount('beneficiaries')->get()->sum('beneficiaries_count') / $this->capacity;
        } else {
            return null;
        }
    }

    public function getTocPourcentageAttribute()
    {
        return round($this->toc * 100);
    }

    public function getCapacityAttribute()
    {
        return $this->lots()->sum('capacity');
    }
}
