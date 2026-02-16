<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaires extends Model
{
    use HasFactory, HasUuids;

    protected $fillable=[
        'id_partenaire',
        'nom_partenaire',
        'logo_partenaire',
        'lien_partenaire',
        'description_partenaire',
        'duree_partenaire'

    ];

    public function organismes(){
        return $this->hasMany(\App\Models\Organismes::class);
    }
}
