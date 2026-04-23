<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Realisations extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'id_realisation';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_realisation',
        'id_departement',
        'id_projet',
        'id_planning',
        'date_attribution_realisation',
        'date_fin_realisation',
    ];

    protected $casts = [
        'date_attribution_realisation' => 'date',
        'date_fin_realisation'         => 'date',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departements::class, 'id_departement', 'id_departement');
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projets::class, 'id_projet', 'id_projet');
    }

    public function planning(): BelongsTo
    {
        return $this->belongsTo(Planning::class, 'id_planning', 'id_planning');
    }
}
