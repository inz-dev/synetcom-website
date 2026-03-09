<?php

namespace Database\Seeders;

use App\Models\Emails;
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
     'id_email'=>Emails::first()->id_email
        ]);
           SocialMedias::create([
     'nom_social_media'=>'gmail',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
     'id_telephone'=>Telephones::select('id_telephone')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_telephone'],
     'id_email'=>Emails::select('id_email')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_email'],
        ]);
           SocialMedias::create([
     'nom_social_media'=>'yahoo',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
    'id_telephone'=>Telephones::select('id_telephone')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_telephone'],
     'id_email'=>Emails::select('id_email')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_email'],
        ]);
           SocialMedias::create([
     'nom_social_media'=>'yahoo',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
    'id_telephone'=>Telephones::select('id_telephone')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_telephone'],
    'id_email'=>Emails::select('id_email')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_email'],
        ]);
           SocialMedias::create([
     'nom_social_media'=>'gmail',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
     'id_telephone'=>Telephones::select('id_telephone')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_telephone'],
     'id_email'=>Emails::select('id_email')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_email'],
        ]);
           SocialMedias::create([
     'nom_social_media'=>'yahoo',
     'lien_social_media'=>null,
     'logo_social_media'=>null,
     'id_telephone'=>Telephones::select('id_telephone')->orderBy('created_at', 'asc')->skip(5)->take(1)->get()[0]['id_telephone'],
     'id_email'=>Emails::select('id_email')->orderBy('created_at', 'asc')->skip(5)->take(1)->get()[0]['id_email'],
        ]);

    }
}
