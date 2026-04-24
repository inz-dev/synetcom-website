<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * PostgreSQL ne supporte pas max(uuid) (utilisé par ofMany/latestOfMany de Laravel).
 * Cette migration convertit toutes les colonnes uuid natives en varchar(36),
 * ce qui préserve les valeurs et rend max() fonctionnel.
 */
return new class extends Migration
{
    // ── Colonnes à convertir ────────────────────────────────────────────────
    private function columns(): array
    {
        return [
            'about_us'                    => ['id_about_us'],
            'cards'                       => ['id_card'],
            'clients'                     => ['id_client', 'id_organisme'],
            'client_has_projets'          => ['id_client_has_projets', 'id_client', 'id_organisme', 'id_projet'],
            'departements'                => ['id_departement'],
            'departements_has_employes'   => ['id_departement', 'id_employe'],
            'emails'                      => ['id_email'],
            'employes'                    => ['id_employe'],
            'employes_has_social_medias'  => ['id_employes_has_social_media', 'id_employe', 'id_social_media'],
            'menus'                       => ['id_menu'],
            'organisme_has_social_medias' => ['id_organisme', 'id_social_media'],
            'organismes'                  => ['id_organisme'],
            'pages'                       => ['id_page'],
            'pages_has_menus'             => ['id_pages_has_menus', 'id_page', 'id_menu'],
            'pages_has_sections'          => ['id_pages_has_sections', 'id_page', 'id_section'],
            'partenaires'                 => ['id_partenaire'],
            'postes'                      => ['id_poste', 'id_employe', 'id_departement'],
            'projets'                     => ['id_projet'],
            'realisations'                => ['id_realisation', 'id_departement', 'id_projet'],
            'reports'                     => ['id_report'],
            'sections'                    => ['id_section'],
            'sections_has_cards'          => ['id_sections_has_cards', 'id_section', 'id_card'],
            'services'                    => ['id_service', 'departement_id'],
            'settings'                    => ['id_setting'],
            'social_medias'               => ['id_social_media', 'id_telephone', 'id_email'],
            'telephones'                  => ['id_telephone'],
        ];
    }

    // ── Contraintes FK avec leurs actions ON DELETE ─────────────────────────
    private function foreignKeys(): array
    {
        // [table, constraint_name, column, ref_table, ref_column, on_delete]
        return [
            ['postes',                     'postes_id_employe_foreign',                              'id_employe',     'employes',     'id_employe',     null],
            ['postes',                     'postes_id_departement_foreign',                          'id_departement', 'departements', 'id_departement', null],
            ['departements_has_employes',  'departements_has_employes_id_departement_foreign',       'id_departement', 'departements', 'id_departement', null],
            ['departements_has_employes',  'departements_has_employes_id_employe_foreign',           'id_employe',     'employes',     'id_employe',     null],
            ['employes_has_social_medias', 'employes_has_social_medias_id_employe_foreign',          'id_employe',     'employes',     'id_employe',     null],
            ['employes_has_social_medias', 'employes_has_social_medias_id_social_media_foreign',     'id_social_media','social_medias','id_social_media',null],
            ['social_medias',              'social_medias_id_telephone_foreign',                     'id_telephone',   'telephones',   'id_telephone',   'SET NULL'],
            ['social_medias',              'social_medias_id_email_foreign',                         'id_email',       'emails',       'id_email',       'SET NULL'],
            ['organisme_has_social_medias','organisme_has_social_medias_id_organisme_foreign',       'id_organisme',   'organismes',   'id_organisme',   null],
            ['organisme_has_social_medias','organisme_has_social_medias_id_social_media_foreign',    'id_social_media','social_medias','id_social_media',null],
            ['pages_has_menus',            'pages_has_menus_id_page_foreign',                        'id_page',        'pages',        'id_page',        null],
            ['pages_has_menus',            'pages_has_menus_id_menu_foreign',                        'id_menu',        'menus',        'id_menu',        null],
            ['pages_has_sections',         'pages_has_sections_id_page_foreign',                     'id_page',        'pages',        'id_page',        null],
            ['pages_has_sections',         'pages_has_sections_id_section_foreign',                  'id_section',     'sections',     'id_section',     null],
            ['sections_has_cards',         'sections_has_cards_id_section_foreign',                  'id_section',     'sections',     'id_section',     null],
            ['sections_has_cards',         'sections_has_cards_id_card_foreign',                     'id_card',        'cards',        'id_card',        null],
            ['clients',                    'clients_id_organisme_foreign',                           'id_organisme',   'organismes',   'id_organisme',   null],
            ['client_has_projets',         'client_has_projets_id_client_foreign',                   'id_client',      'clients',      'id_client',      null],
            ['client_has_projets',         'client_has_projets_id_organisme_foreign',                'id_organisme',   'organismes',   'id_organisme',   null],
            ['client_has_projets',         'client_has_projets_id_projet_foreign',                   'id_projet',      'projets',      'id_projet',      null],
            ['realisations',               'realisations_id_departement_foreign',                    'id_departement', 'departements', 'id_departement', null],
            ['realisations',               'realisations_id_projet_foreign',                         'id_projet',      'projets',      'id_projet',      null],
            ['services',                   'services_departement_id_foreign',                        'departement_id', 'departements', 'id_departement', null],
        ];
    }

    // ── Helpers ─────────────────────────────────────────────────────────────
    private function dropFks(): void
    {
        foreach ($this->foreignKeys() as [$table, $name]) {
            DB::statement("ALTER TABLE \"{$table}\" DROP CONSTRAINT IF EXISTS \"{$name}\"");
        }
    }

    private function changeColumnType(string $table, string $col, string $newType, string $usingExpr): void
    {
        DB::statement(
            "ALTER TABLE \"{$table}\" ALTER COLUMN \"{$col}\" TYPE {$newType} USING \"{$col}\"{$usingExpr}"
        );
    }

    private function addFks(): void
    {
        foreach ($this->foreignKeys() as [$table, $name, $col, $refTable, $refCol, $onDelete]) {
            $onDeleteSql = $onDelete ? " ON DELETE {$onDelete}" : '';
            DB::statement(
                "ALTER TABLE \"{$table}\" ADD CONSTRAINT \"{$name}\" "
                . "FOREIGN KEY (\"{$col}\") REFERENCES \"{$refTable}\"(\"{$refCol}\"){$onDeleteSql}"
            );
        }
    }

    // ── up() : uuid → varchar(36) ────────────────────────────────────────────
    public function up(): void
    {
        $this->dropFks();

        foreach ($this->columns() as $table => $cols) {
            foreach ($cols as $col) {
                $this->changeColumnType($table, $col, 'varchar(36)', '::varchar');
            }
        }

        $this->addFks();
    }

    // ── down() : varchar(36) → uuid ──────────────────────────────────────────
    public function down(): void
    {
        $this->dropFks();

        foreach ($this->columns() as $table => $cols) {
            foreach ($cols as $col) {
                $this->changeColumnType($table, $col, 'uuid', '::uuid');
            }
        }

        $this->addFks();
    }
};
