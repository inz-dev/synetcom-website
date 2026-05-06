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
        Schema::create('opportunites', function (Blueprint $table) {
            $table->uuid('id_opportunite')->primary();
            $table->string('titre_opportunite');
            $table->text('description_opportunite');
            $table->enum('type_contrat', ['CDI', 'CDD', 'Stage', 'Alternance', 'Freelance']);
            $table->string('lieu_opportunite')->nullable();
            $table->date('date_limite')->nullable();
            $table->boolean('est_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunites');
    }
};
