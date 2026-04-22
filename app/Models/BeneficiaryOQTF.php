<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeneficiaryOQTF extends Model
{
    use HasFactory;

    protected $table = 'beneficiary_oqtfs';

    protected $fillable = [
        'date_notification_48h',
        'date_notification_15d',
        'date_appeal',
        'date_notification_TA',
        'decision_TA',
        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
