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

    public static function forPage(string $titre): ?array
    {
        $page = static::where('titre_page', $titre)
            ->with(['sections' => fn($q) => $q->with('cards')])
            ->first();

        if (!$page) return null;

        return [
            'titre_page'       => $page->titre_page,
            'slogan_page'      => $page->slogan_page,
            'description_page' => $page->description_page,
            'banniere_page'    => $page->banniere_page,
            'sections'         => $page->sections->map(fn($s) => [
                'nom_section'         => $s->nom_section,
                'description_section' => $s->description_section,
                'icon_section'        => $s->icon_section,
                'cards'               => $s->cards->map(fn($c) => [
                    'titre_card'        => $c->titre_card,
                    'description_card'  => $c->description_card,
                    'icon_card'         => $c->icon_card,
                    'titre_bouton_card' => $c->titre_bouton_card,
                ])->values(),
            ])->values(),
        ];
    }

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
