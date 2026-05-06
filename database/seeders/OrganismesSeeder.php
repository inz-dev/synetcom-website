<?php

namespace Database\Seeders;

use App\Models\Emails;
use App\Models\Organismes;
use App\Models\Telephones;
use Illuminate\Database\Seeder;

class OrganismesSeeder extends Seeder
{
    public function run(): void
    {
        Organismes::firstOrCreate(
            ['nom_organisme' => 'Synetcom'],
            [
                'nom_organisme'      => 'Synetcom',
                'adresse_organisme'  => '13743 Niamey-NIGER, Face Pharmacie Maisons économiques',
                'logo_organisme'     => '/images/logo.png',
                'slogan_organisme'   => 'Développez votre entreprise chaque jour avec la transformation numérique. Nous vous permettons de générer de la croissance grâce aux outils digitaux.',
                'lien_map_organisme' => 'https://www.google.com/maps?q=13.5137,2.1098',
            ]
        );

        // Numéros de contact principaux
        Telephones::firstOrCreate(['telephone' => 90717476], ['code_telephone' => '+227', 'telephone' => 90717476]);
        Telephones::firstOrCreate(['telephone' => 88888811], ['code_telephone' => '+227', 'telephone' => 88888811]);


        // Adresses email de contact
        Emails::firstOrCreate(['email' => 'contact@synetcom.ne']);
        Emails::firstOrCreate(['email' => 'info@synetcom.ne']);
        Emails::firstOrCreate(['email' => 'chaibou.abdou@synetcom.dev']);
    }
}
