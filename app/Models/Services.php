<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory,HasUuids;
      protected $fillable=[
    'id_service',
    'nom_service',
    'description_service',
    'icon_service',
    'departements_id'
    ];

    public function departements(){
        return $this->hasMany(\App\Models\Departements::class);
    }
}
