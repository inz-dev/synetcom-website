<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{

    use HasFactory;
    public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
    protected $primaryKey = 'id_client';
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
        'id_client',
        'nom_client',
        'logo_client',
        'lien_client',
        'description_client',
        'duree_client',
        'est_partenaire_client'

    ];

    public function organismes()
    {
        return $this->hasMany(\App\Models\Organismes::class);
    }
}
