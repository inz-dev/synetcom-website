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
        Schema::create('pages_has_menus', function (Blueprint $table) {
            $table->uuid('id_pages_has_menus')->primary()->unique();
                        $table->foreignUuid('id_page')->index()->references('id_page')->on('pages');
            $table->foreignUuid('id_menu')->index()->references('id_menu')->on('menus');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages_has_menus');
    }
};
