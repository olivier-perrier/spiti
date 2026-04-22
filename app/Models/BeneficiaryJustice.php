<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryJustice extends Model
{
    use HasFactory;

    protected $fillable = [
        'orienteer',
        'cpip',
        'dentention_place',
        'detention_start',
        'date_cap',
        'detention_end',
        'court_procedure',
        'procedure_duration',

        'obligations',
        'prohibitions',
        'date_adjustment_request',
        'adjustment_refused',
        'adjustment_description',
        'adjustment_durantion',
        'tig_compelled',
        'internship',
    ];

    protected $casts = [
        'obligations' => 'array',
        'prohibitions' => 'array',
    ];
}
