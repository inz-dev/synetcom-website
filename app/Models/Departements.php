<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departements extends Model
{
    use HasFactory,HasUuids;

     protected $fillable=[
        'id_departement',
        'nom_departement',
    ];

     public function services(){
         return  $this->belongsTo(\App\Models\Services::class,'id_service');
        }
        public function departements_has_employes(){
        return $this->belongsToMany(\App\Models\DepartementsHasEmployes::class);
    }

}
