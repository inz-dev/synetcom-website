<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Candidature extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id_candidature',
        'id_opportunite',
        'nom_candidat',
        'prenom_candidat',
        'email_candidat',
        'telephone_candidat',
        'message_candidature',
        'cv_path',
        'statut',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id_candidature';

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    public function opportunite()
    {
        return $this->belongsTo(Opportunites::class, 'id_opportunite', 'id_opportunite');
    }
}
