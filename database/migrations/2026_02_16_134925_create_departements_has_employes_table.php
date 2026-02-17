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
        Schema::create('departements_has_employes', function (Blueprint $table) {
        /* $table->foreignId('id_employe')->constrained('employes', 'id_employe')->index();
        $table->foreignId('id_departement')->constrained('departements', 'id_departement')->index();*/
            $table->foreignUuid(\App\Models\Departements::class)
            ->index()->references('id_departement')->on('departements');
             $table->foreignUuid(\App\Models\Employes::class)
            ->index()->references('id_employe')->on('employes');
           /*  $table->uuid('id_departement','id_employe')->primary(); */
            $table->date('date_debut');
             $table->date('date_fin');
             $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departements_has_employes');
    }
};
