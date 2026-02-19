<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;
use Webpatser\Uuid\Uuid;
class OrganismeHasSocialMedias extends Model
{
    use HasFactory, HasCompositeKey;
    public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
       protected $primaryKey=[
        'id_organisme',
        'id_social_media',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    protected $fillable=[
      'organismes_id',
        'social_medias_id',
    ];

    public function organismes(){
        return $this->hasMany(\App\Models\Organismes::class);
    }
    public function socialMedias(){
        return $this->hasMany(\App\Models\socialMedias::class);
    }
}
