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
        Schema::create('partenaires', function (Blueprint $table) {
            $table->uuid('id_partenaire')->primary()->unique();
            $table->string('nom_partenaire');
                        $table->string('secteur_color_partenaire')->nullable();
                                    $table->string('secteur_partenaire')->nullable();
            $table->string('logo_partenaire')->nullable();
            $table->string('lien_partenaire')->nullable();
            $table->string('description_partenaire')->nullable();
            $table->string('duree_partenaire')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partenaires');
    }
};
