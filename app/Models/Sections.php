<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Sections extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id_section';

    protected static function boot(): void
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
        'icon_section',
        'is_link_section',
    ];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Pages::class, 'pages_has_sections', 'id_section', 'id_page')
                    ->withTimestamps();
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'sections_has_cards', 'id_section', 'id_card')
                    ->withTimestamps();
    }
}
