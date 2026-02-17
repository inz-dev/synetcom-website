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

    protected $fillable=[
    'id_organisme',
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
