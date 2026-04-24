<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_team',
        'image_team',
        'bio_team',
        'badge_team',
        'badge_color_team',
        'id_employe',
        'ordre',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employes::class, 'id_employe', 'id_employe');
    }
}
