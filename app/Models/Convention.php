<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Convention extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dispositif_id',
        'partner_id',
        'signature_date',
        'end_date',
        'start_date',
        'status_id',
        'funding',
        'theme',
        'subtheme',
        'goals',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function dispositif(): BelongsTo
    {
        return $this->belongsTo(Dispositif::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Type::class)->where('typeable_type', Convention::class.'.type');
    }
}
