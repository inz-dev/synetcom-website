<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

class Services extends Model
{
    use HasFactory,HasUuids;
     public $incrementing = false;   // pas d'auto-incrément
    protected $keyType = 'string';  // type string au lieu d'int
    protected $primaryKey = 'id_service';
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
    'id_service',
    'nom_service',
    'description_service',
    'icon_service',
    'departement_id'
    ];
  public function departements():BelongsTo{
         return  $this->belongsTo(\App\Models\Departements::class,'departement_id','id_departement');
        }

}
