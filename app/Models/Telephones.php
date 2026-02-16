<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telephones extends Model
{
    use HasFactory, HasUuids;
    protected $fillable=['id_telephone', 'code telephone', 'telephone'];

    public function socialMedia(){
        return $this->belongsTo(\App\Models\SocialMedias::class);
    }
}
