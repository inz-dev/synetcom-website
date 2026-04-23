<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id_page';

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
        'id_page',
        'titre_page',
        'description_page',
        'slogan_page',
        'banniere_page',
    ];

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Sections::class, 'pages_has_sections', 'id_page', 'id_section')
                    ->withTimestamps();
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menus::class);
    }
}
