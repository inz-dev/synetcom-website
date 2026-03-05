<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
class Menus extends Model
{
    use HasFactory;
     public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
    protected $primaryKey = 'id_menu';
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
        'id_menu',
        'titre_menu',
        'description_menu',
        'a_sousmenu',

    ];

     public function pages(){
        return $this->belongsToMany(\App\Models\Pages::class);
    }
}
