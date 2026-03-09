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
        Schema::create('clients', function (Blueprint $table) {
           $table->uuid('id_client')->primary();
            $table->string('nom_client');
            $table->string('logo_client')->nullable();
            $table->string('lien_client')->nullable();
            $table->string('description_client')->nullable();
            $table->date('duree_client')->nullable();
            $table->bigInteger('est_partenaire_client')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
