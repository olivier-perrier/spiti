<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeneficiarySanitary extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_monotoring',
        'date_health_check',
        'date_medical_visit',
        'date_expeted_delivery',
        'attending_doctor',
        'comments',

        'vitale_card',
        'medical_support',
        'health_issue',
        'curatorship',
        'guardianship',
        'complementary',
        'general_system',

        'title_medical_care_entry',
        'date_start_medical_care_entry',
        'date_end_medical_care_entry',

        'title_medical_care_supplementary_entry',
        'date_start_medical_care_supplementary_entry',
        'date_end_medical_care_supplementary_entry',

        'title_medical_care',
        'date_deposit_medical_care',
        'date_start_medical_care',
        'date_end_medical_care',

        'title_medical_care_supplementary',
        'date_deposit_medical_care_supplementary',
        'date_start_medical_care_supplementary',
        'date_end_medical_care_supplementary',
    ];

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }
}
