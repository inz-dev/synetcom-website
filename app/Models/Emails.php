<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
class Emails extends Model
{
    use HasFactory, HasUuids;
    protected $fillable=['id_email','email'];
    public $incrementing=false;
     protected $keyType='string';
     protected $primaryKey = 'id_email';

     protected static function boot()
     {
        parent::boot();
         static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });

     }

    public function socialMedias(){
        return $this->hasMany(\App\Models\SocialMedias::class,'id_social_media');
    }
}
