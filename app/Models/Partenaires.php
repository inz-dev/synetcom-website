<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaires extends Model
{
    use HasFactory;
public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
    protected $primaryKey = 'id_partenaire';
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
        'id_partenaire',
        'nom_partenaire',
        'logo_partenaire',
        'lien_partenaire',
        'description_partenaire',
        'duree_partenaire'

    ];

    public function organismes(){
        return $this->hasMany(\App\Models\Organismes::class);
    }
}
