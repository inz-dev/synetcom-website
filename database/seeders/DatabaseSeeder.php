<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            PagesSeeder::class,
            TelephoneSeeder::class,
            EmailSeeder::class,
            SocialMediasSeeder::class,
            DepartementsSeeder::class,
            EmployesSeeder::class,
            OrganismesSeeder::class,
            EmployesHasSocialMediasSeeder::class,

        ]);
    }
}
