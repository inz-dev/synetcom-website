<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Postes extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'id_poste',
        'nom_poste',
        'type_contrat',
        'date_debut_poste',
        'date_fin_poste',
        'id_employe',
        'id_departement',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id_poste';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employes::class, 'id_employe', 'id_employe');
    }

    public function departements(): BelongsTo
    {
        return $this->belongsTo(Departements::class, 'id_departement', 'id_departement');
    }
}
