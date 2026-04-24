<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

class Employes extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id_employe',
        'nom_employe',
        'adresse_employe',
        'profil_employe',
        'date_embauche_employe',
        'type_contrat',
        'user_id',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id_employe';

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function postes(): HasMany
    {
        return $this->hasMany(Postes::class, 'id_employe', 'id_employe');
    }

    public function latestPoste(): HasOne
    {
        // ofMany() génère max(uuid) qui n'est pas supporté par PostgreSQL.
        // orderByDesc sur date est suffisant : hasOne prend la 1ère ligne per FK.
        return $this->hasOne(Postes::class, 'id_employe', 'id_employe')
                    ->orderByDesc('date_debut_poste')
                    ->orderByDesc('created_at');
    }

    public function departements(): BelongsToMany
    {
        return $this->belongsToMany(Departements::class, 'departements_has_employes', 'id_employe', 'id_departement')
                    ->withPivot(['date_debut', 'date_fin'])
                    ->withTimestamps();
    }

    public function socialMedias(): BelongsToMany
    {
        return $this->belongsToMany(SocialMedias::class, 'employes_has_social_medias', 'id_employe', 'id_social_media')
                    ->withPivot(['actif_employes_has_social_media'])
                    ->withTimestamps();
    }
}
