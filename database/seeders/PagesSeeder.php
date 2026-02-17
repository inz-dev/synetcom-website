<?php

namespace Database\Seeders;

use App\Models\Pages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Pages::create([
            'titre_page' => 'Accueil',
            'description_page' => 'Accueil',
            'slogan_page' => 'Développer votre entreprise chaque jour avec la transformation numérique.
                Nous vous permettons de générer de la croissance grâce aux outils de la transformation numérique.',
            'banniere_page' => 'background1.png'
        ]);
        Pages::create([

            'titre_page' => 'Qui sommes-nous?',
            'description_page' => 'Qui sommes-nous?',
            'slogan_page' => 'Développer votre entreprise chaque jour avec la transformation numérique.
  Nous vous permettons de générer de la croissance grâce aux outils de la transformation numérique.',
            'banniere_page' => 'background1.png'
        ]);
        Pages::create([

            'titre_page' => 'Services',
            'description_page' => 'Qui sommes-nous?',
            'slogan_page' => 'Développer votre entreprise chaque jour avec la transformation numérique.
  Nous vous permettons de générer de la croissance grâce aux outils de la transformation numérique.',
            'banniere_page' => 'background1.png'
        ]);
    }
}
