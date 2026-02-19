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
        Schema::create('organisme_has_social_medias', function (Blueprint $table) {
         $table->foreignUuid('id_organisme')
         ->index()->references('id_organisme')->on('organismes');
        $table->foreignUuid('id_social_media')->index()->references('id_social_media')->on('social_medias');
        $table->softDeletes();
/*             $table->primary('id_organisme','id_social_media');
 */        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisme_has_social_medias');
    }
};
