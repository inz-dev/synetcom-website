<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections_has_cards', function (Blueprint $table) {
            $table->uuid('id_sections_has_cards')->primary()->unique();
            $table->foreignUuid('id_section')->index()->references('id_section')->on('sections')->cascadeOnDelete();
            $table->foreignUuid('id_card')->index()->references('id_card')->on('cards')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections_has_cards');
    }
};
