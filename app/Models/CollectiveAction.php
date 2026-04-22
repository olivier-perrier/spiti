<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CollectiveAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dispositif_id',

        'objectif',
        'theme',
        'subtheme',
        'target',
        'description',

        'start_date',
        'end_date',
        'duration',
        'mobilisation',
        'location',

        'participation',
        'summary',
        'status',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function dispositif(): BelongsTo
    {
        return $this->belongsTo(Dispositif::class);
    }

    public function partners(): BelongsToMany
    {
        return $this->belongsToMany(Partner::class);
    }

    public function beneficiaries(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiary::class);
    }
}
