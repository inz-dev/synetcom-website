<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Sections extends Model
{
    use HasFactory;
      public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
    protected $primaryKey = 'id_section';
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
        'id_section',
        'nom_section',
        'description_section',
         'icone_section',
        'is_link_section',

    ];
}
