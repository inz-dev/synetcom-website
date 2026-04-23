<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Projets extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'id_projet';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_projet',
        'nom_projet',
        'description_projet',
        'image_projet',
        'fichier_projet',
        'id_planning',
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

    public function planning(): BelongsTo
    {
        return $this->belongsTo(Planning::class, 'id_planning', 'id_planning');
    }

    public function realisations(): HasMany
    {
        return $this->hasMany(Realisations::class, 'id_projet', 'id_projet');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_has_projets', 'id_projet', 'id_client')
                    ->withPivot(['id_organisme', 'id_planning', 'date_debut_pp', 'date_fin_pp'])
                    ->withTimestamps();
    }
}
