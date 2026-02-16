<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class OrganismeHasSocialMedias extends Model
{
    use HasFactory, HasCompositeKey;
     protected $primaryKey=[
        'organismes_id',
        'social_medias_id',
    ];

    protected $fillable=[
      'organismes_id',
        'social_medias_id',
    ];
}
