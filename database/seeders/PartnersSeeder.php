<?php

namespace Database\Seeders;

use App\Models\Partenaires;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $partners = [

            [
                'nom_partenaire' => 'Nita Transfert',
                'secteur_partenaire' => 'Services Financiers',
                'secteur_color_partenaire' => '#059669',
                'logo_partenaire' => '/images/logo-nita.jpeg',
                'lien_partenaire' => 'https://nitatransfert.com/',
                'description_partenaire' => 'Nita Transfert est une société de transfert d\'argent opérant au Niger. Synetcom accompagne Nita dans la digitalisation de ses opérations et le développement de ses outils numériques pour améliorer l\'expérience client.',
                'duree_partenaire' => '3ans',
            ],
             [
                'nom_partenaire' => 'Nita Transfert',
                'secteur_partenaire' => 'Services Financiers',
                'secteur_color_partenaire' => '#059669',
                'logo_partenaire' => '/images/logo-nita.jpeg',
                'lien_partenaire' => 'https://nitatransfert.com/',
                'description_partenaire' => 'Nita Transfert est une société de transfert dargent opérant au Niger. Synetcom accompagne Nita dans la digitalisation de ses opérations et le développement de ses outils numériques pour améliorer lexpérience client.',
                'duree_partenaire' => '3ans',
            ],
              [
                'nom_partenaire' => 'Amana Transfert',
                'secteur_partenaire' => 'Services Financiers',
                'secteur_color_partenaire' => '#059669',
                'logo_partenaire' => '/images/amana-nita.jpeg',
                'lien_partenaire' => 'https://amana-transfert.com/',
                'description_partenaire' =>'Amana Transfert est un acteur majeur du transfert de fonds au Niger. En partenariat avec Synetcom, Amana bénéficie de solutions technologiques adaptées pour sécuriser et fluidifier ses transactions.',
                'duree_partenaire' => '3ans'
            ],
            [
                'nom_partenaire' => 'Enabel Niger',
                'secteur_partenaire' => 'Coopération au développement',
                'secteur_color_partenaire' => '#1b449c',
                'logo_partenaire' => '/images/logo-enabel.jpeg',
                'lien_partenaire' => 'https=>//www.enabel.be/fr/country/niger/',
                'description_partenaire' =>'Enabel est l\'Agence belge de développement. Au Niger, elle met en œuvre des programmes de coopération internationale. Synetcom soutient Enabel dans ses besoins en solutions numériques et en renforcement des capacités.',
                'duree_partenaire' => '5 ans'
            ],
             [
                'nom_partenaire' => 'ORIBA',
                'secteur_partenaire' => 'Agroalimentaire',
                'secteur_color_partenaire' => '#d97706',
                'logo_partenaire' => '/images/logo-enabel.jpeg',
                'lien_partenaire' => 'https=>//www.enabel.be/fr/country/niger/',
                'description_partenaire' =>'ORIBA est une entreprise spécialisée dans la production et la commercialisation du riz au Niger. Synetcom accompagne ORIBA dans sa transformation digitale pour optimiser sa gestion et renforcer sa visibilité en ligne.',
                'duree_partenaire' => '6 ans'
            ],

            [
                'nom_partenaire' => 'UNICEF Niger',
                'secteur_partenaire' => 'Organisation internationale',
                'secteur_color_partenaire' => '#0284c7',
                'logo_partenaire' => '/images/unicef-logo.jpeg',
                'lien_partenaire' => 'https=>//www.unicef.org/niger/',
                'description_partenaire' =>'L\'UNICEF œuvre pour les droits et le bien-être des enfants dans le monde entier. Au Niger, Synetcom contribue aux initiatives de l\'UNICEF en fournissant des outils numériques et des services informatiques adaptés à leurs missions.',
                'duree_partenaire' => '6 ans'
            ],
        ];

        foreach( $partners as $data){
            Partenaires::updateOrCreate(
                ['nom_partenaire' =>$data['nom_partenaire']],
                $data
            );
        }
    }
        }

