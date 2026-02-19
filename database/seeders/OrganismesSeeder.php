<?php

namespace Database\Seeders;

use App\Models\Organismes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganismesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Organismes::create([
    'nom_organisme'=>'Synetcom',
    'adresse_organisme'=>'13743 Niamey-NIGER, Face Pharmacie Maisons économiques',
    'logo_organisme'=>'logo-synetcom',
    'slogan_organisme'=>'Développer votre entreprise chaque jour avec la transformation numérique. Nous vous permettons de générer de la croissance grâce aux outils de la transformation numérique.'

        ]);
    }
}
