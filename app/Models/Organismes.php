<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organismes extends Model
{
    use HasFactory, HasUuids;
    protected $fillable=['id_organisme',
    'nom_organisme',
    'adresse_organisme',
    'logo_organisme',
    'slogan_organisme'];

    public function socialMeadias(){
        return $this->belongsToMany(\App\Models\SocialMedias::class);
}
public function partenaires(){
        return $this->belongsTo(\App\Models\Partenaires::class);
    }
}
