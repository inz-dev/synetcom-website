<?php

namespace App\Models;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telephones extends Model
{
    use HasFactory, HasUuids;
    protected $fillable=['id_telephone', 'code telephone', 'telephone'];

    public $incrementing=false;
     protected $keyType='string';
     protected $primaryKey = 'id_telephone';

     protected static function boot()
     {
        parent::boot();
         static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });

     }
    public function socialMedia(){
        return $this->belongsTo(\App\Models\SocialMedias::class);
    }
}
