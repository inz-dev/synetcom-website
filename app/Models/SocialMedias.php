<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedias extends Model
{
    use HasFactory, HasUuids;
     protected $fillable=[
     'id_social_media',
     'nom_social_media',
     'lien_social_media',
     'logo_social_media',
     'telephones_id'];


    public function organismes(){
        return $this->belongsToMany(\App\Models\Organismes::class,'id_organisme');
    }
     public function employes(){
        return $this->belongsToMany(\App\Models\Employes::class,'id_employe');
    }

    public function telephones(){
        return $this->hasMany(\App\Models\telephones::class);
    }
}
