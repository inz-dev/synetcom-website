<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory, HasUuids;
    protected $fillable=['id_email','email'];

    public function socialMedias(){
        return $this->belongsTo(\App\Models\SocialMedias::class,'id_social_media');
    }
}
