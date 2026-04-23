<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisations', function (Blueprint $table) {
            $table->uuid('id_realisation')->primary()->unique();
            $table->foreignUuid('id_departement')->index()->references('id_departement')->on('departements')->cascadeOnDelete();
            $table->foreignUuid('id_projet')->nullable()->index()->references('id_projet')->on('projets')->nullOnDelete();
            $table->unsignedBigInteger('id_planning')->nullable();
            $table->foreign('id_planning')->references('id_planning')->on('planning')->nullOnDelete();
            $table->date('date_attribution_realisation')->nullable();
            $table->date('date_fin_realisation')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisations');
    }
};
