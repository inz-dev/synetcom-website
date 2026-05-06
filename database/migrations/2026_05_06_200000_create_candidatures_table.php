<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->uuid('id_candidature')->primary();
            $table->uuid('id_opportunite');
            $table->foreign('id_opportunite')
                  ->references('id_opportunite')
                  ->on('opportunites')
                  ->onDelete('cascade');
            $table->string('nom_candidat');
            $table->string('prenom_candidat');
            $table->string('email_candidat');
            $table->string('telephone_candidat')->nullable();
            $table->text('message_candidature');
            $table->string('cv_path')->nullable();
            $table->enum('statut', ['en_attente', 'vue', 'acceptee', 'refusee'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
