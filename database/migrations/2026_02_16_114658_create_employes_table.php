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
        Schema::create('employes', function (Blueprint $table) {
            $table->uuid('id_employe')->primary()->unique();
             $table->string('nom_employe');
             $table->string('adresse_employe')->nullable();
             $table->string('profil_employe')->nullable();
             $table->date('date_embauche_employe')->default(now());
              $table->string('type_contrat')->nullable();
              $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
