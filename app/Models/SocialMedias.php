<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;
class SocialMedias extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
     protected $fillable=[
     'id_social_media',
     'nom_social_media',
     'lien_social_media',
     'logo_social_media',
     'id_telephone',
     'id_email',
     'is_mobile'];

public $incrementing=false;
     protected $keyType='string';
     protected $primaryKey = 'id_social_media';

     protected static function boot()
     {
        parent::boot();
         static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });

     }
    public function organismes(){
        return $this->belongsToMany(\App\Models\Organismes::class, 'organisme_has_social_medias', 'id_social_media', 'id_organisme');
    }
    public function employes(){
        return $this->belongsToMany(\App\Models\Employes::class, 'employes_has_social_medias', 'id_social_media', 'id_employe')
                    ->withPivot(['actif_employes_has_social_media'])
                    ->withTimestamps();
    }

    public function telephones(){
        return $this->belongsTo(\App\Models\telephones::class, 'id_telephone', 'id_telephone');
    }

    public function emails(){
        return $this->belongsTo(\App\Models\emails::class, 'id_email', 'id_email');
    }
}
