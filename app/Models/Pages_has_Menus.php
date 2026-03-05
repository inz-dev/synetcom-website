<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pages_has_Menus extends Model
{
    use HasFactory, HasUuids;
      public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
    protected $primaryKey = 'id_pages_has_menus';
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
        'id_pages_has_menus',
        'id_page',
        'id_menu',

    ];


}
