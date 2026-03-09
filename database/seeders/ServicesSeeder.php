<?php

namespace Database\Seeders;

use App\Models\Departements;
use App\Models\Services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    Services::create([
        'nom_service' =>'Développement et Intégration de solution digitale',
          'description' =>'Développement et Intégration de solution digitale',
          'id_departement'=>Departements::first()->id_departement,

        ]);
        Services::create([
        'nom_service' =>'Développement d’apps web/Mobile',
          'description' =>'Développement d’apps web/Mobile',
          'id_departement'=>Departements::first()->id_departement,
        ]);
        Services::create([
        'nom_service' =>'Création de sites web',
          'description' =>'Création de sites web',
          'id_departement'=>Departements::first()->id_departement,
        ]);

         Services::create([
        'nom_service' =>'Administration de bases de données',
          'description' =>'Administration de bases de données',
          'id_departement'=>Departements::first()->id_departement,
        ]);

          Services::create([
        'nom_service' =>'Hébergement et Référencement SEO',
          'description' =>'Hébergement et Référencement SEO',
          'id_departement'=>Departements::first()->id_departement,
        ]);
          Services::create([
        'nom_service' =>'Étude, Conseil et Formation en renforcement de capacité en Informatique',
          'description' =>'Étude, Conseil et Formation en renforcement de capacité en Informatique',
          'id_departement'=>Departements::first()->id_departement,
        ]);

         Services::create([
        'nom_service' =>'Impression des gadgets et supports de visibilité',
          'description' =>'Impression des gadgets et supports de visibilité',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_departement'],
        ]);
          Services::create([
        'nom_service' =>'Impression des Panneaux publicitaires',
          'description' =>'Impression des Panneaux publicitaires',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Administration et Sécurité des réseaux informatiques',
          'description' =>'Administration et Sécurité des réseaux informatiques',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Maintenance des réseaux informatiques',
          'description' =>'Maintenances des réseaux informatiques',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
        Services::create([
        'nom_service' =>'Installation des systèmes réseaux',
          'description' =>'Installation des systèmes réseaux',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Vente de Matériels et Consommables',
          'description' =>'Vente de Matériels et Consommables',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Vente des ordinateurs',
          'description' =>'Vente des ordinateurs',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_departement'],
        ]);
          Services::create([
        'nom_service' =>'Ingenierie des données',
          'description' =>'Ingenierie des données',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);

          Services::create([
        'nom_service' =>'Collecte,Analyse et Interprétations des données',
          'description' =>'Collecte,Analyse et Interprétations des données',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);

          Services::create([
        'nom_service' =>'Analyse et Audit de Système d’information',
          'description' =>'Analyse et Audit de Système d’information',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);
    }
}
