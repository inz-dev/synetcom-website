<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

class Departements extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id_departement',
        'nom_departement',
        'description_departement',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id_departement';

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    public function services(): HasMany
    {
        return $this->hasMany(Services::class, 'departement_id', 'id_departement');
    }

    public function postes(): HasMany
    {
        return $this->hasMany(Postes::class, 'id_departement', 'id_departement');
    }

    public function realisations(): HasMany
    {
        return $this->hasMany(Realisations::class, 'id_departement', 'id_departement');
    }

    public function employes(): BelongsToMany
    {
        return $this->belongsToMany(Employes::class, 'departements_has_employes', 'id_departement', 'id_employe')
                    ->withPivot(['date_debut', 'date_fin'])
                    ->withTimestamps();
    }
}
