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
            $table->foreignUuid(\App\Models\Employes::class)
            ->index()->references('id_employe')->on('employes');
            $table->foreignUuid(\App\Models\SocialMedias::class)
            ->index()->references('id_social_media')->on('social_medias');
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
