<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planning extends Model
{
    use HasFactory;

    protected $table = 'planning';
    protected $primaryKey = 'id_planning';
    protected $fillable = ['id_planning'];

    public function projets(): HasMany
    {
        return $this->hasMany(Projets::class, 'id_planning', 'id_planning');
    }

    public function realisations(): HasMany
    {
        return $this->hasMany(Realisations::class, 'id_planning', 'id_planning');
    }

    public function clientHasProjets(): HasMany
    {
        return $this->hasMany(ClientHasProjets::class, 'id_planning', 'id_planning');
    }
}
