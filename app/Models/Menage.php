<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dispositif_id',
        'date_entry',
        // 'family_composition',
        // 'preview_accommodation_id',
        'has_social_right',
        'badge_key',
        'animal',
        'animal_type',

        'referent_id',
        // 'orientation_id',
        // 'family_composition_id ',
        // 'domiciliation_id ',
        // 'team_id ',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function dispositif(): BelongsTo
    {
        return $this->belongsTo(Dispositif::class);
    }

    public function referent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referent_id');
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class, 'menage_id');
    }
}
