<?php

namespace Database\Seeders;

use App\Models\SocialMedias;
use App\Models\Telephones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SocialMedias::create([
     'nom_social_media'=>'autre',
    'id_telephone'=>Telephones::first()->id_telephone,
     'id_email'=>null
        ]);
           SocialMedias::create([
     'nom_social_media'=>'gmail',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
     'id_telephone'=>null,
     'id_email'=>null
        ]);
           SocialMedias::create([
     'nom_social_media'=>'yahoo',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
     'id_telephone'=>null,
     'id_email'=>null
        ]);
           SocialMedias::create([
     'nom_social_media'=>'yahoo',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
    'id_telephone'=>null,
     'id_email'=>null
        ]);
           SocialMedias::create([
     'nom_social_media'=>'gmail',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
     'id_telephone'=>null,
     'id_email'=>null
        ]);
           SocialMedias::create([
     'nom_social_media'=>'yahoo',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
     'id_telephone'=>null,
     'id_email'=>null
        ]);

    }
}
