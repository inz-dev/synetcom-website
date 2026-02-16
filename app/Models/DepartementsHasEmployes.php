<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class DepartementsHasEmployes extends Model
{
    use HasFactory,HasCompositeKey,HasUuids;
     protected $primaryKey=[
          'id_employe',
        'id_departement',
    ];
    protected $fillable=[
         'id_employe',
        'id_departement',
        'date_debut',
        'date_fin',
        ];

          public function employes(){
        return $this->hasMany(\App\Models\Employes::class);
    }
    public function departements(){
        return $this->hasMany(\App\Models\Departements::class);
    }


}
