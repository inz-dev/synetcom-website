<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class SectionsHasCards extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'sections_has_cards';
    protected $primaryKey = 'id_sections_has_cards';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_sections_has_cards',
        'id_section',
        'id_card',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        });
    }
}
