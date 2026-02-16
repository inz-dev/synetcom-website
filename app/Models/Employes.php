<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employes extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
'id_employe',
'nom_employe',
'adresse_employe',
           'profil_employe',
           'date_embauche_employe',
            'type_contrat'
    ];

     public function departements(){
        return $this->belongsTo(\App\Models\Departements::class);
    }
     public function departements_has_employes(){
        return $this->belongsToMany(\App\Models\DepartementsHasEmployes::class);
    }
    public function social_medias(){
        return $this->belongsToMany(\App\Models\SocialMedias::class);
    }
}
