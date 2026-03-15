<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;
class Departements extends Model
{
    use HasFactory,HasUuids;

     protected $fillable=[
        'id_departement',
        'nom_departement',
        'description_departement'
        ];
public $incrementing=false;
     protected $keyType='string';
     protected $primaryKey = 'id_departement';

     protected static function boot()
     {
        parent::boot();
         static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });

     }
    public function services():HasMany{
        return $this->hasMany(\App\Models\Services::class, 'departement_id','id_departement');
    }
        public function departements_has_employes(){
        return $this->belongsToMany(\App\Models\DepartementsHasEmployes::class);
    }

}
