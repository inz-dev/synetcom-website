<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
class Postes extends Model
{

    use HasFactory,HasUuids;

    protected $fillable = [
        'id_poste',
        'nom_poste',
        'date_debut_poste',
        'date_fin_poste',
        'id_employe',
        'type_contrat'
    ];
     public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
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

    public function departements()
    {
        return $this->belongsTo(\App\Models\Departements::class);
    }


}
