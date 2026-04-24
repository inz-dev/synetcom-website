<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_team',
        'name_team',
        'image_team',
        'bio_team',
        'badge_team',
        'badge_color_team',
        'id_employe',
        'ordre',
    ];
    public $incrementing=false;
     protected $keyType='string';
     protected $primaryKey = 'id_team';

     protected static function boot()
     {
        parent::boot();
         static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });

     }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employes::class, 'id_employe', 'id_employe');
    }
}
