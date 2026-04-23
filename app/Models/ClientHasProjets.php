<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class ClientHasProjets extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'client_has_projets';
    protected $primaryKey = 'id_client_has_projets';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_client_has_projets',
        'id_client',
        'id_organisme',
        'id_projet',
        'id_planning',
        'date_debut_pp',
        'date_fin_pp',
    ];

    protected $casts = [
        'date_debut_pp' => 'date',
        'date_fin_pp'   => 'date',
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

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }

    public function organisme(): BelongsTo
    {
        return $this->belongsTo(Organismes::class, 'id_organisme', 'id_organisme');
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
