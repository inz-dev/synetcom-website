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
        Schema::create('postes', function (Blueprint $table) {
            $table->uuid('id_poste')->primary()->unique();
            $table->string('nom_poste')->primary();
            $table->date('date_debut_poste')->default(now());
             $table->date('date_fin_poste')->default(now());
            $table->foreignUuid('id_employe') ->index()->references('id_employe')->on('employes');
            $table->foreignUuid('id_departement')->index()->references('id_departement')->on('departements');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postes');
    }
};
