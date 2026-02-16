<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class EmployesHasSocialMedias extends Model
{
    use HasFactory, HasCompositeKey;
     protected $primaryKey=[
        'employes_id',
        'social_medias_id',
    ];

    protected $fillable=[
       'employes_id',
        'social_medias_id',
    ];
     public function employes(){
        return $this->hasMany(\App\Models\Employes::class,'id_employe');
    }
    public function socialMedias(){
        return $this->hasMany(\App\Models\SocialMedias::class,'id_social_media');
    }
}
