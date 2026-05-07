<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partenaires', function (Blueprint $table) {
            if (!Schema::hasColumn('partenaires', 'secteur_partenaire')) {
                $table->string('secteur_partenaire')->nullable()->after('nom_partenaire');
            }
            if (!Schema::hasColumn('partenaires', 'secteur_color_partenaire')) {
                $table->string('secteur_color_partenaire')->nullable()->after('secteur_partenaire');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partenaires', function (Blueprint $table) {
            $table->dropColumn(['secteur_partenaire', 'secteur_color_partenaire']);
        });
    }
};
