<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Thiagoprz\CompositeKey\HasCompositeKey;
use Webpatser\Uuid\Uuid;
class EmployesHasSocialMedias extends Model
{
    use HasFactory, HasCompositeKey;

public $incrementing = true;
protected $keyType='string';
     protected $primaryKey=[
        'id_employes',
        'id_social_media',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(
            function($model){
                $model->{$model->getKeyName()}= Uuid::generate()->string;
            }
        );
    }

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
