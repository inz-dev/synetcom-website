<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->uuid('id_projet')->primary()->unique();
            $table->string('nom_projet');
            $table->text('description_projet')->nullable();
            $table->string('image_projet')->nullable();
            $table->string('fichier_projet')->nullable();
            $table->unsignedBigInteger('id_planning')->nullable();
            $table->foreign('id_planning')->references('id_planning')->on('planning')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
