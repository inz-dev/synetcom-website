<?php

namespace Database\Seeders;

use App\Models\Employes;
use App\Models\Telephones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Employes::create([
        'nom_employe'=>'Chaibou ABDOU',
        'adresse_employe'=>'Niamey/Niger',
        'profil_employe'=>'Ingénieur Réseaux et CEO',
        'date_embauche_employe'=>'2005-02-19',
        'type_contrat'=>'autre'
        ]);
         Employes::create([
        'nom_employe'=>'Mamane Laouali ALI GAMBO',
        'adresse_employe'=>'Niamey/Niger',
        'profil_employe'=>'Développeur Web/Mobile',
        'date_embauche_employe'=>'2020-08-20',
        'type_contrat'=>'CDI'
        ]);

         Employes::create([
        'nom_employe'=>'Ismael NOURI',
        'adresse_employe'=>'Niamey/Niger',
        'profil_employe'=>'Développeur Web/Mobile',
        'date_embauche_employe'=>'2021-06-04',
        'type_contrat'=>'CDD'
        ]);

         Employes::create([
        'nom_employe'=>'Zeinabou ISSAKA NOUHOU',
        'adresse_employe'=>'Niamey/Niger',
        'profil_employe'=>'Ingénieur Web/Mobile',
        'date_embauche_employe'=>'2020-06-20',
        'type_contrat'=>'CDD'
        ]);

         Employes::create([
        'nom_employe'=>'Abdoul-Azize',
        'adresse_employe'=>'Niamey/Niger',
        'profil_employe'=>'Concepteurs et Administrateur BD',
        'date_embauche_employe'=>'2023-11-17',
        'type_contrat'=>'Stage'
        ]);

         Employes::create([
        'nom_employe'=>'Zakariyaou',
        'adresse_employe'=>'Niamey/Niger',
        'profil_employe'=>'Devops et Réseaux',
        'date_embauche_employe'=>'2023-11-17',
        'type_contrat'=>'Stage'
        ]);
    }
}
