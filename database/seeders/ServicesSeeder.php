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
          'departement_id'=>Departements::first()->id_departement,

        ]);
        Services::create([
        'nom_service' =>'Développement d’apps web/Mobile',
          'description_service' =>'Développement d’apps web/Mobile',
          'departement_id'=>Departements::first()->id_departement,
        ]);
        Services::create([
        'nom_service' =>'Création de sites web',
          'description_service' =>'Création de sites web',
          'departement_id'=>Departements::first()->id_departement,
        ]);

         Services::create([
        'nom_service' =>'Administration de bases de données',
          'description_service' =>'Administration de bases de données',
          'departement_id'=>Departements::first()->id_departement,
        ]);

          Services::create([
        'nom_service' =>'Hébergement et Référencement SEO',
          'description_service' =>'Hébergement et Référencement SEO',
          'departement_id'=>Departements::first()->id_departement,
        ]);
          Services::create([
        'nom_service' =>'Étude, Conseil et Formation en renforcement de capacité en Informatique',
          'description_service' =>'Étude, Conseil et Formation en renforcement de capacité en Informatique',
          'departement_id'=>Departements::first()->id_departement,
        ]);

         Services::create([
        'nom_service' =>'Impression des gadgets et supports de visibilité',
          'description_service' =>'Impression des gadgets et supports de visibilité',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_departement'],
        ]);
          Services::create([
        'nom_service' =>'Impression des Panneaux publicitaires',
          'description_service' =>'Impression des Panneaux publicitaires',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(1)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Administration et Sécurité des réseaux informatiques',
          'description_service' =>'Administration et Sécurité des réseaux informatiques',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Maintenance des réseaux informatiques',
          'description_service' =>'Maintenances des réseaux informatiques',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
        Services::create([
        'nom_service' =>'Installation des systèmes réseaux',
          'description_service' =>'Installation des systèmes réseaux',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(2)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Vente de Matériels et Consommables',
          'description_service' =>'Vente de Matériels et Consommables',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_departement'],
        ]);
         Services::create([
        'nom_service' =>'Vente des ordinateurs',
          'description_service' =>'Vente des ordinateurs',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(3)->take(1)->get()[0]['id_departement'],
        ]);
          Services::create([
        'nom_service' =>'Ingenierie des données',
          'description_service' =>'Ingenierie des données',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);

          Services::create([
        'nom_service' =>'Collecte,Analyse et Interprétations des données',
          'description_service' =>'Collecte,Analyse et Interprétations des données',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);

          Services::create([
        'nom_service' =>'Analyse et Audit de Système d’information',
          'description_service' =>'Analyse et Audit de Système d’information',
          'departement_id'=>Departements::select('id_departement')->orderBy('created_at', 'asc')->skip(4)->take(1)->get()[0]['id_departement'],
        ]);
    }
}
