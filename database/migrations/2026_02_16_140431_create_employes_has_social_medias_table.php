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
        Schema::create('employes_has_social_medias', function (Blueprint $table) {
            $table->uuid('id_employes_has_social_media')->primary();
            $table->foreignUuid('id_employe')->index()->references('id_employe')->on('employes');
            $table->foreignUuid('id_social_media')->index()->references('id_social_media')->on('social_medias');
            $table->bigInteger('actif_employes_has_social_media')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes_has_social_medias');
    }
};
