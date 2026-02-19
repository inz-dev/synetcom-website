<?php

namespace Database\Seeders;

use App\Models\Departements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Departements::create(['nom_departement'=>'Développement web/Mobile' ]);
         Departements::create(['nom_departement'=>'Impression des gadgets et supports de visibilité' ]);
         Departements::create(['nom_departement'=>'Administration et Sécurité des réseaux informatiques' ]);
          Departements::create(['nom_departement'=>'Vente de Matériels et Consommables' ]);
           Departements::create(['nom_departement'=>'Étude, Conseil et Formation en renforcement de capacité en Informatique' ]);

    }
}
