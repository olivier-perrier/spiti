<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'building',
        'floor',
        'surface',
        'capacity',
        'agreed_capacity',
        'PMR',
        'team_id',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class)->where('typeable_type', Lot::class);
    }

    public function residence(): BelongsTo
    {
        return $this->belongsTo(Residence::class);
    }

    public function dispositifs(): HasManyThrough
    {
        return $this->hasManyThrough(Dispositif::class, Residence::class, 'dispositif_id', 'id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function getTocAttribute()
    {
        if ($this->capacity) {
            return $this->beneficiaries_count / $this->capacity;
        } else {
            return null;
        }
    }

    public function scopeAvailability(Builder $query)
    {
        // todo : j'ai honte de ce code => il faut asolument trouver une autre manière de faire !
        $query->whereRaw('(select count(*) from `'.env('DB_PREFIX').'beneficiaries` where `'.env('DB_PREFIX').'lots`.`id` = `'.env('DB_PREFIX').'beneficiaries`.`lot_id`) < '.env('DB_PREFIX').'lots.capacity');
        // $query->has("beneficiaries", "<", 10);
    }

    public function getTocPourcentageAttribute()
    {
        return round($this->toc * 100);
    }
}
