<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Dispositif extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'finess_number',
        'opening_date',
        'closing_date',
        'address_id',
    ];

    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
    ];

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
        return $this->belongsTo(Type::class)->where('typeable_type', Dispositif::class);
    }

    public function lots(): HasManyThrough
    {
        return $this->hasManyThrough(Lot::class, Residence::class);
    }

    public function residences(): HasMany
    {
        return $this->hasMany(Residence::class);
    }

    public function conventions(): HasMany
    {
        return $this->hasMany(Convention::class);
    }

    public function collectiveActions(): HasMany
    {
        return $this->hasMany(CollectiveAction::class);
    }
}
