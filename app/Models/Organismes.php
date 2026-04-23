<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Organismes extends Model
{
    use HasFactory;

    public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
    protected $primaryKey = 'id_organisme';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }

    protected $fillable = [
        'id_organisme',
        'nom_organisme',
        'adresse_organisme',
        'logo_organisme',
        'slogan_organisme',
        'lien_map_organisme',
    ];

    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Client::class, 'id_organisme', 'id_organisme');
    }

    public function socialMedias(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(SocialMedias::class, 'organisme_has_social_medias', 'id_organisme', 'id_social_media')
                    ->withTimestamps();
    }
}
