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
        Schema::create('social_medias', function (Blueprint $table) {
            $table->uuid('id_social_media')->primary();
            $table->string('nom_social_media');
            $table->string('lien_social_media')->nullable();
             $table->string('logo_social_media')->nullable();
  $table->foreignIdFor(\App\Models\Telephones::class)
         ->nullable()->references('id_telephone')->on('telephones')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_medias');
    }
};
