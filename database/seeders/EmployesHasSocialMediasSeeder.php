<?php

namespace Database\Seeders;

use App\Models\Employes;
use App\Models\EmployesHasSocialMedias;
use App\Models\SocialMedias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployesHasSocialMediasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        EmployesHasSocialMedias::create([
             'id_employe'=>Employes::first()->id_employe,
             'id_social_media'=>SocialMedias::first()->id_social_media,
        ]);
         EmployesHasSocialMedias::create([
             'id_employe'=>Employes::select('id_employe')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_employe'],
             'id_social_media'=>SocialMedias::select('id_social_media')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_social_media'],
        ]);
         EmployesHasSocialMedias::create([
             'id_employe'=>Employes::select('id_employe')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_employe'],
             'id_social_media'=>SocialMedias::select('id_social_media')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_social_media'],
        ]);
         EmployesHasSocialMedias::create([
             'id_employe'=>Employes::select('id_employe')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_employe'],
             'id_social_media'=>SocialMedias::select('id_social_media')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_social_media'],
        ]);

         EmployesHasSocialMedias::create([
             'id_employe'=>Employes::select('id_employe')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_employe'],
             'id_social_media'=>SocialMedias::select('id_social_media')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_social_media'],
        ]);
         EmployesHasSocialMedias::create([
             'id_employe'=>Employes::select('id_employe')->orderBy('created_at', 'asc')->skip(5)->take(1)->get()[0]['id_employe'],
             'id_social_media'=>SocialMedias::select('id_social_media')->orderBy('created_at', 'asc')->skip(5)->take(1)->get()[0]['id_social_media'],
        ]);
    }
}
