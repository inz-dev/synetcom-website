<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_has_projets', function (Blueprint $table) {
            $table->uuid('id_client_has_projets')->primary()->unique();
            $table->foreignUuid('id_client')->index()->references('id_client')->on('clients')->cascadeOnDelete();
            $table->foreignUuid('id_organisme')->nullable()->index()->references('id_organisme')->on('organismes')->nullOnDelete();
            $table->foreignUuid('id_projet')->nullable()->index()->references('id_projet')->on('projets')->nullOnDelete();
            $table->unsignedBigInteger('id_planning')->nullable();
            $table->foreign('id_planning')->references('id_planning')->on('planning')->nullOnDelete();
            $table->date('date_debut_pp')->nullable();
            $table->date('date_fin_pp')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_has_projets');
    }
};
