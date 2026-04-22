<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeneficiaryEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id',

        'school_level',
        'diploma',
        'languages',
        'equivalence_ENIC',

        'french_oral_level',
        'french_written_level',
        'french_diploma_level',
        'date_french_diploma',

        'school_situation',
        'school_name',
        'reason_no_school',
        'special_class',

        'school_address_id',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'school_address_id');
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }
}
