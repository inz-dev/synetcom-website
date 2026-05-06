<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Opportunites extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id_opportunite',
        'titre_opportunite',
        'description_opportunite',
        'type_contrat',
        'lieu_opportunite',
        'date_limite',
        'est_active',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id_opportunite';

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_opportunite', 'id_opportunite');
    }
}
