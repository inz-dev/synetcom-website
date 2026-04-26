<?php

namespace Database\Seeders;

use App\Models\Employes;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'nom'        => 'Chaibou ABDOU',
                'badge'      => 'CEO',
                'badge_color'=> '#1b449c',
                'bio'        => 'Fondateur et CEO de Synetcom, ingénieur réseaux avec plus de 20 ans d\'expérience en infrastructures télécoms et systèmes d\'information.',
                'image'      => '/images/member1.png',
                'ordre'      => 1,
            ],
            [
                'nom'        => 'Mamane Laouali ALI GAMBO',
                'badge'      => 'Dev Web/Mobile',
                'badge_color'=> '#2563eb',
                'bio'        => 'Développeur full-stack spécialisé en applications web et mobiles, passionné par les technologies modernes et les solutions innovantes.',
                'image'      => '/images/member2.png',
                'ordre'      => 2,
            ],
            [
                'nom'        => 'Ismael NOURI',
                'badge'      => 'Dev Web/Mobile',
                'badge_color'=> '#2563eb',
                'bio'        => 'Développeur web et mobile axé sur la qualité du code et l\'expérience utilisateur, avec une forte expertise en intégration d\'API.',
                'image'      => '/images/member3.png',
                'ordre'      => 3,
            ],
            [
                'nom'        => 'Zeinabou ISSAKA NOUHOU',
                'badge'      => 'Ingénieure Web/Mobile',
                'badge_color'=> '#7c3aed',
                'bio'        => 'Ingénieure web et mobile, conceptrice d\'interfaces ergonomiques et développeuse de solutions robustes pour les besoins métier.',
                'image'      => '/images/member2.png',
                'ordre'      => 4,
            ],
            [
                'nom'        => 'Abdoul-Azize',
                'badge'      => 'Admin BD',
                'badge_color'=> '#059669',
                'bio'        => 'Concepteur et administrateur de bases de données, garant de la performance, de l\'intégrité et de la sécurité des données.',
                'image'      => '/images/member1.png',
                'ordre'      => 5,
            ],
            [
                'nom'        => 'Zakariyaou',
                'badge'      => 'DevOps',
                'badge_color'=> '#d97706',
                'bio'        => 'Ingénieur DevOps et réseaux, spécialisé dans l\'automatisation des déploiements, la gestion des infrastructures et la supervision des systèmes.',
                'image'      => '/images/member3.png',
                'ordre'      => 6,
            ],
        ];

        foreach ($members as $data) {
            $employe = Employes::where('nom_employe', $data['nom'])->first();

            Team::updateOrCreate(
                ['name_team' => $data['nom']],
                [
                    'image_team'       => $data['image'],
                    'bio_team'         => $data['bio'],
                    'badge_team'       => $data['badge'],
                    'badge_color_team' => $data['badge_color'],
                    'id_employe'       => $employe?->id_employe,
                    'ordre'            => $data['ordre'],
                ]
            );
        }
    }
}
