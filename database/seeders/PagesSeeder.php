<?php

namespace Database\Seeders;

use App\Models\Pages;
use App\Models\Sections;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'page' => [
                    'titre_page'       => 'Accueil',
                    'slogan_page'      => 'Développez votre entreprise chaque jour avec la transformation numérique. Nous vous permettons de générer de la croissance grâce aux outils digitaux.',
                    'description_page' => 'Page d\'accueil du site Synetcom-Niger',
                    'banniere_page'    => 'background1.png',
                ],
                'sections' => [
                    ['nom_section' => 'Bannière principale',   'description_section' => 'Développez votre entreprise chaque jour avec la transformation numérique.',          'icon_section' => 'mdi-home-outline'],
                    ['nom_section' => 'Nos Services',          'description_section' => 'Des solutions numériques complètes pour accompagner votre croissance à chaque étape.', 'icon_section' => 'mdi-briefcase-outline'],
                    ['nom_section' => 'Réalisations',          'description_section' => 'Découvrez une sélection de projets réalisés pour nos clients.',                       'icon_section' => 'mdi-image-outline'],
                    ['nom_section' => 'Pourquoi nous choisir', 'description_section' => 'Les raisons de faire confiance à Synetcom pour votre transformation digitale.',        'icon_section' => 'mdi-check-decagram-outline'],
                    ['nom_section' => 'Notre Équipe',          'description_section' => 'Des professionnels passionnés qui unissent leurs expertises.',                         'icon_section' => 'mdi-account-group-outline'],
                    ['nom_section' => 'Newsletter',            'description_section' => 'Restez informé de nos actualités et offres.',                                          'icon_section' => 'mdi-email-newsletter'],
                    ['nom_section' => 'Nos Partenaires',       'description_section' => 'Des organisations et entreprises qui nous font confiance.',                            'icon_section' => 'mdi-handshake-outline'],
                ],
            ],
            [
                'page' => [
                    'titre_page'       => 'Qui sommes-nous?',
                    'slogan_page'      => 'Notre équipe d\'experts vous accompagne avec un service personnalisé, disponible 24h/24 et 7j/7.',
                    'description_page' => 'Qui sommes-nous?',
                    'banniere_page'    => 'background1.png',
                ],
                'sections' => [
                    ['nom_section' => 'À propos de Synetcom', 'description_section' => 'Notre histoire, notre vision et nos engagements depuis 2015.',         'icon_section' => 'mdi-information-outline'],
                    ['nom_section' => 'Notre Mission',        'description_section' => 'Accompagner les organisations dans leur transformation digitale.',      'icon_section' => 'mdi-star-outline'],
                    ['nom_section' => 'Nos Valeurs',          'description_section' => 'Rigueur, innovation, proximité et engagement au service de nos clients.', 'icon_section' => 'mdi-check-decagram-outline'],
                ],
            ],
            [
                'page' => [
                    'titre_page'       => 'Services',
                    'slogan_page'      => 'Des solutions numériques complètes pour accompagner votre croissance à chaque étape.',
                    'description_page' => 'Nos Services',
                    'banniere_page'    => 'background1.png',
                ],
                'sections' => [
                    ['nom_section' => 'Introduction', 'description_section' => 'Depuis plus de 9 ans, nous accompagnons les entreprises et organisations du Niger dans leur transformation digitale avec des solutions adaptées à chaque besoin.', 'icon_section' => 'mdi-briefcase-outline'],
                ],
            ],
            [
                'page' => [
                    'titre_page'       => 'Réalisations',
                    'slogan_page'      => 'Découvrez une sélection de projets réalisés pour nos clients — applications, impressions et supports visuels.',
                    'description_page' => 'Nos Réalisations',
                    'banniere_page'    => 'background1.png',
                ],
                'sections' => [
                    ['nom_section' => 'Nos Projets', 'description_section' => 'Applications web, mobiles, impressions et supports visuels réalisés pour nos clients.', 'icon_section' => 'mdi-image-outline'],
                ],
            ],
            [
                'page' => [
                    'titre_page'       => 'Équipe',
                    'slogan_page'      => 'Des professionnels passionnés qui unissent leurs expertises pour faire de votre transformation digitale une réussite.',
                    'description_page' => 'Notre Équipe',
                    'banniere_page'    => 'background1.png',
                ],
                'sections' => [
                    ['nom_section' => 'Notre Équipe', 'description_section' => 'Des professionnels passionnés qui unissent leurs expertises pour votre succès.', 'icon_section' => 'mdi-account-group-outline'],
                ],
            ],
            [
                'page' => [
                    'titre_page'       => 'Partenaires',
                    'slogan_page'      => 'Des organisations et entreprises qui nous font confiance pour accompagner leur transformation numérique.',
                    'description_page' => 'Nos Partenaires',
                    'banniere_page'    => 'background1.png',
                ],
                'sections' => [
                    ['nom_section' => 'Nos Partenaires', 'description_section' => 'Ils nous font confiance pour les accompagner dans leur transformation numérique.', 'icon_section' => 'mdi-handshake-outline'],
                ],
            ],
            [
                'page' => [
                    'titre_page'       => 'Contact',
                    'slogan_page'      => 'Une question, un projet, un devis ? Notre équipe vous répond dans les plus brefs délais.',
                    'description_page' => 'Nous Contacter',
                    'banniere_page'    => 'background1.png',
                ],
                'sections' => [
                    ['nom_section' => 'Formulaire de contact', 'description_section' => 'Envoyez-nous votre message et nous vous répondrons rapidement.',        'icon_section' => 'mdi-email-newsletter'],
                    ['nom_section' => 'Nos coordonnées',       'description_section' => 'Retrouvez nos adresses, numéros de téléphone et réseaux sociaux.', 'icon_section' => 'mdi-map-marker-outline'],
                ],
            ],
        ];

        foreach ($data as $item) {
            $page = Pages::create($item['page']);

            foreach ($item['sections'] as $sData) {
                $section = Sections::create($sData);
                DB::table('pages_has_sections')->insert([
                    'id_pages_has_sections' => Uuid::generate()->string,
                    'id_page'               => $page->id_page,
                    'id_section'            => $section->id_section,
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ]);
            }
        }
    }
}
