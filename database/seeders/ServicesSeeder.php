<?php

namespace Database\Seeders;

use App\Models\Departements;
use App\Models\Services;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $depts = Departements::orderBy('created_at', 'asc')->pluck('id_departement');

        $d0 = $depts[0] ?? null;
        $d1 = $depts[1] ?? null;
        $d2 = $depts[2] ?? null;
        $d3 = $depts[3] ?? null;
        $d4 = $depts[4] ?? null;

        $services = [
            // Département 0 — Digital / Développement
            [
                'nom_service'         => 'Développement & Intégration Digitale',
                'description_service' => 'Conception et déploiement de solutions logicielles sur mesure pour digitaliser vos processus métier. Nous intégrons les meilleurs outils numériques pour transformer votre organisation et améliorer votre efficacité opérationnelle.',
                'icon_service'        => 'mdi-laptop',
                'color'               => '#1b449c',
                'paths'               => ['M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v10m0 0H5a2 2 0 00-2 2v4h6m-6 0h14m0-14v10m0 0h-4a2 2 0 00-2 2v4m0 0h6'],
                'departement_id'      => $d0,
            ],
            [
                'nom_service'         => 'Développement Web & Mobile',
                'description_service' => 'Création d\'applications web et mobiles performantes, intuitives et adaptées à vos utilisateurs. Nous développons des solutions sur mesure qui répondent précisément à vos besoins métier.',
                'icon_service'        => 'mdi-code-braces',
                'color'               => '#7c3aed',
                'paths'               => ['M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                'departement_id'      => $d0,
            ],
            [
                'nom_service'         => 'Création de sites web',
                'description_service' => 'Conception et développement de sites web modernes, responsives et optimisés pour votre image de marque.',
                'icon_service'        => 'mdi-web',
                'color'               => '#1b449c',
                'paths'               => ['M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
                'departement_id'      => $d0,
            ],
            [
                'nom_service'         => 'Administration de bases de données',
                'description_service' => 'Gestion, optimisation et sécurisation de vos bases de données pour garantir performance et intégrité des données.',
                'icon_service'        => 'mdi-database-outline',
                'color'               => '#059669',
                'paths'               => ['M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4'],
                'departement_id'      => $d0,
            ],
            [
                'nom_service'         => 'Hébergement & Référencement SEO',
                'description_service' => 'Hébergement sécurisé de vos plateformes numériques et optimisation SEO pour améliorer votre visibilité en ligne, attirer plus de visiteurs et convertir en clients fidèles.',
                'icon_service'        => 'mdi-cloud-outline',
                'color'               => '#0284c7',
                'paths'               => ['M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
                'departement_id'      => $d0,
            ],
            [
                'nom_service'         => 'Formation & Renforcement de Capacités',
                'description_service' => 'Formations professionnelles en informatique et technologies pour développer les compétences de vos équipes. Nous proposons des programmes adaptés à tous les niveaux pour assurer votre montée en puissance.',
                'icon_service'        => 'mdi-school-outline',
                'color'               => '#059669',
                'paths'               => [
                    'M12 14l9-5-9-5-9 5 9 5z',
                    'M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                ],
                'departement_id'      => $d0,
            ],

            // Département 1 — Impression / Visibilité
            [
                'nom_service'         => 'Impression & Supports de Visibilité',
                'description_service' => 'Impression de gadgets, brochures, banderoles et supports publicitaires pour renforcer votre image de marque et votre présence sur le terrain auprès de vos clients et partenaires.',
                'icon_service'        => 'mdi-printer-outline',
                'color'               => '#f15a2d',
                'paths'               => [
                    'M17 17H17.01M17 3H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2z',
                    'M17 3v6l-2-1-2 1V3',
                ],
                'departement_id'      => $d1,
            ],
            [
                'nom_service'         => 'Impression des Panneaux publicitaires',
                'description_service' => 'Fabrication et installation de panneaux publicitaires grand format pour maximiser votre visibilité sur le terrain.',
                'icon_service'        => 'mdi-bullhorn-outline',
                'color'               => '#f15a2d',
                'paths'               => ['M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                'departement_id'      => $d1,
            ],

            // Département 2 — Réseaux / Sécurité
            [
                'nom_service'         => 'Administration & Sécurité Réseau',
                'description_service' => 'Gestion, monitoring et sécurisation de vos infrastructures réseaux pour assurer continuité et protection de vos données critiques contre les menaces internes et externes.',
                'icon_service'        => 'mdi-shield-check-outline',
                'color'               => '#dc2626',
                'paths'               => ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                'departement_id'      => $d2,
            ],
            [
                'nom_service'         => 'Maintenance des réseaux informatiques',
                'description_service' => 'Maintenance préventive et corrective de vos infrastructures réseau pour garantir une disponibilité maximale.',
                'icon_service'        => 'mdi-hammer-wrench',
                'color'               => '#dc2626',
                'paths'               => [
                    'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                    'M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                ],
                'departement_id'      => $d2,
            ],
            [
                'nom_service'         => 'Installation des systèmes réseaux',
                'description_service' => 'Installation et configuration de systèmes réseaux locaux, WiFi et VPN pour vos infrastructures.',
                'icon_service'        => 'mdi-lan',
                'color'               => '#dc2626',
                'paths'               => ['M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01'],
                'departement_id'      => $d2,
            ],

            // Département 3 — Vente matériels
            [
                'nom_service'         => 'Vente de Matériels Informatiques',
                'description_service' => 'Fourniture de matériels et consommables informatiques de qualité pour équiper vos espaces de travail. Nous sélectionnons des équipements fiables et performants adaptés à votre budget.',
                'icon_service'        => 'mdi-cart-outline',
                'color'               => '#7c3aed',
                'paths'               => ['M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                'departement_id'      => $d3,
            ],
            [
                'nom_service'         => 'Vente des ordinateurs',
                'description_service' => 'Vente d\'ordinateurs portables, fixes et accessoires de marques reconnues pour vos besoins professionnels.',
                'icon_service'        => 'mdi-laptop',
                'color'               => '#7c3aed',
                'paths'               => ['M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                'departement_id'      => $d3,
            ],

            // Département 4 — Data / Analyse
            [
                'nom_service'         => 'Ingénierie des données',
                'description_service' => 'Conception et mise en place de pipelines de données robustes pour collecter, traiter et centraliser vos informations métier.',
                'icon_service'        => 'mdi-chart-bar',
                'color'               => '#d97706',
                'paths'               => ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                'departement_id'      => $d4,
            ],
            [
                'nom_service'         => 'Collecte & Analyse des Données',
                'description_service' => 'Collecte, traitement et visualisation de vos données pour une prise de décision éclairée basée sur les faits et les tendances réelles du marché. Nous transformons vos données en insights actionnables.',
                'icon_service'        => 'mdi-chart-bar',
                'color'               => '#d97706',
                'paths'               => ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                'departement_id'      => $d4,
            ],
            [
                'nom_service'         => 'Audit & Analyse des Systèmes d\'information',
                'description_service' => 'Évaluation complète de vos systèmes d\'information pour identifier les risques, optimiser les performances et garantir la pérennité et la sécurité de votre infrastructure numérique.',
                'icon_service'        => 'mdi-clipboard-check-outline',
                'color'               => '#1b449c',
                'paths'               => ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                'departement_id'      => $d4,
            ],
        ];

        foreach ($services as $data) {
            Services::updateOrCreate(
                ['nom_service' => $data['nom_service']],
                $data
            );
        }
    }
}
