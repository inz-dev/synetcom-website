<?php

namespace Database\Seeders;

use App\Models\Departements;
use App\Models\Services;
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
          'description_service' =>'Développement et Intégration de solution digitale',
          'id_departement'=>Departements::first()->id_departement,

        ]);
        Services::create([
        'nom_service' =>'Développement d’apps web/Mobile',
          'description_service' =>'Développement d’apps web/Mobile',
          'id_departement'=>Departements::first()->id_departement,
        ]);
        Services::create([
        'nom_service' =>'Création de sites web',
          'description_service' =>'Création de sites web',
          'id_departement'=>Departements::first()->id_departement,
        ]);

         Services::create([
        'nom_service' =>'Administration de bases de données',
          'description_service' =>'Administration de bases de données',
          'id_departement'=>Departements::first()->id_departement,
        ]);

          Services::create([
        'nom_service' =>'Hébergement et Référencement SEO',
          'description_service' =>'Hébergement et Référencement SEO',
          'id_departement'=>Departements::first()->id_departement,
        ]);
          Services::create([
        'nom_service' =>'Étude, Conseil et Formation en renforcement de capacité en Informatique',
          'description_service' =>'Étude, Conseil et Formation en renforcement de capacité en Informatique',
          'id_departement'=>Departements::first()->id_departement,
        ]);

         Services::create([
        'nom_service' =>'Impression des gadgets et supports de visibilité',
          'description_service' =>'Impression des gadgets et supports de visibilité',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_departement'],
        ]);
          Services::create([
        'nom_service' =>'Impression des Panneaux publicitaires',
          'description_service' =>'Impression des Panneaux publicitaires',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Administration et Sécurité des réseaux informatiques',
          'description_service' =>'Administration et Sécurité des réseaux informatiques',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Maintenance des réseaux informatiques',
          'description_service' =>'Maintenances des réseaux informatiques',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
        Services::create([
        'nom_service' =>'Installation des systèmes réseaux',
          'description_service' =>'Installation des systèmes réseaux',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Vente de Matériels et Consommables',
          'description_service' =>'Vente de Matériels et Consommables',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Vente des ordinateurs',
          'description_service' =>'Vente des ordinateurs',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_departement'],
        ]);
          Services::create([
        'nom_service' =>'Ingenierie des données',
          'description_service' =>'Ingenierie des données',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);

          Services::create([
        'nom_service' =>'Collecte,Analyse et Interprétations des données',
          'description_service' =>'Collecte,Analyse et Interprétations des données',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);

          Services::create([
        'nom_service' =>'Analyse et Audit de Système d’information',
          'description_service' =>'Analyse et Audit de Système d’information',
          'id_departement'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);
    }
}
