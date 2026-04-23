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
            'slogan_page' => 'Développez votre entreprise chaque jour avec la transformation numérique.Nous vous permettons de générer de la croissance grâce aux outils digitaux.',
            'banniere_page' => 'background1.png'
        ]);
        Pages::create([

            'titre_page' => 'Qui sommes-nous?',
            'description_page' => 'Qui sommes-nous?',
            'slogan_page' =>'Notre équipe d\'experts vous accompagne avec un service personnalisé, disponible 24h/24 et 7j/7. Nous nous engageons à fournir des solutions numériques supérieures et professionnelles adaptées à votre contexte.',
            'banniere_page' => 'background1.png'
        ]);
        Pages::create([
            'titre_page' => 'Services',
            'description_page' => 'Nos Services',
            'slogan_page' => 'Des solutions numériques complètes pour accompagner votre croissance à chaque étape.',
            'banniere_page' => 'background1.png'
        ]);

         Pages::create([

            'titre_page' => 'Réalisations',
            'description_page' => 'Nos Réalisations',
            'slogan_page' => 'Découvrez une sélection de projets réalisés pour nos clients — applications, impressions et supports visuels.',
            'banniere_page' => 'background1.png'
        ]);

         Pages::create([

            'titre_page' => 'Équipe',
            'description_page' => 'Notre Équipe',
            'slogan_page' =>'Des professionnels passionnés qui unissent leurs expertises pour faire de votre transformation digitale une réussite.',
            'banniere_page' => 'background1.png'
        ]);

         Pages::create([

            'titre_page' => 'Partenaires',
            'description_page' => 'Nos Partenaires',
            'slogan_page' => 'Des organisations et entreprises qui nous font confiance pour accompagner leur transformation numérique.',
            'banniere_page' => 'background1.png'
        ]);

         Pages::create([

            'titre_page' => 'Contact',
            'description_page' => 'Nous Contacter',
            'slogan_page' =>'Une question, un projet, un devis ? Notre équipe vous répond dans les plus brefs délais.',
            'banniere_page' => 'background1.png'
        ]);
    }
}
