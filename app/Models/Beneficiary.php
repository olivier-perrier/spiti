<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_name',
        'AGDREF',
        'birthday',
        'sex',
        'nationality',
        'birth_country',
        'birth_city',
        'date_entry_dispositif',
        'family_situation_id',
        'administrative_situation_id',
        'date_arrival_france',

        'phone',
        'mobile_phone',
        'email',

        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function menage(): BelongsTo
    {
        return $this->belongsTo(Menage::class);
    }

    public function referent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referent_id');
    }

    public function typeFamily(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'family_situation_id')->where('typeable_type', Beneficiary::class.'.family');
    }

    public function typeAdministratif(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'administrative_situation_id')->where('typeable_type', Beneficiary::class.'.administratif');
    }

    public function oqtfs(): HasMany
    {
        return $this->hasMany(BeneficiaryOQTF::class);
    }

    public function education(): HasOne
    {
        return $this->hasOne(BeneficiaryEducation::class);
    }

    public function sanitary(): HasOne
    {
        return $this->hasOne(BeneficiarySanitary::class, 'beneficiary_id');
    }

    public function justice(): HasOne
    {
        return $this->hasOne(BeneficiaryJustice::class, 'beneficiary_id');
    }

    public function collectiveActions(): BelongsToMany
    {
        return $this->belongsToMany(CollectiveAction::class);
    }
}
