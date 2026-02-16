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
        Schema::create('organismes', function (Blueprint $table) {
            $table->uuid('id_organisme')->primary();
            $table->string('nom_organisme');
            $table->string('adresse_organisme');
            $table->string('logo_organisme');
            $table->string('slogan_organisme')->default('Notre slogan');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organismes');
    }
};
