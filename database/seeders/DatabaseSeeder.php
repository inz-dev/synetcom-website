<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Seeders à usage unique : protégés par un guard count() === 0.
     * Seeders de données (Services, Team) : toujours exécutés car idempotents (updateOrCreate).
     */
    public function run(): void
    {
        if (DB::table('permissions')->count() === 0) {
            $this->call(PermissionSeeder::class);
        }

        if (DB::table('users')->count() === 0) {
            $this->call(UserSeeder::class);
        }

        if (DB::table('pages')->count() === 0) {
            $this->call(PagesSeeder::class);
        }

        if (DB::table('telephones')->count() === 0) {
            $this->call(TelephoneSeeder::class);
        }

        if (DB::table('emails')->count() === 0) {
            $this->call(EmailSeeder::class);
        }

        if (DB::table('social_medias')->count() === 0) {
            $this->call(SocialMediasSeeder::class);
        }

        if (DB::table('departements')->count() === 0) {
            $this->call(DepartementsSeeder::class);
        }

        if (DB::table('employes')->count() === 0) {
            $this->call(EmployesSeeder::class);
        }

        if (DB::table('organismes')->count() === 0) {
            $this->call(OrganismesSeeder::class);
        }

        if (DB::table('employes_has_social_medias')->count() === 0) {
            $this->call(EmployesHasSocialMediasSeeder::class);
        }

        if (DB::table('services')->count() === 0) {
            $this->call(ServicesSeeder::class);
        }

        if (DB::table('teams')->count() === 0) {
            $this->call(TeamSeeder::class);
        }
    }
}
