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
         $table->foreignIdFor(\App\Models\Organismes::class)
         ->index()->references('id_organisme')->on('organismes');
        $table->foreignIdFor(\App\Models\SocialMedias::class)->index()
                ->references('id_social_media')->on('social_medias');

/*             $table->primary('id_organisme','id_social_media');
 */            $table->timestamps();
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
