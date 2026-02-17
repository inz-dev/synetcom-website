<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            /*$table->uuid('id_page')->default(DB::raw('(UUID())'))->primary()->unique();*/
             $table->uuid('id_page')->primary()->unique();
            $table->string('titre_page');
             $table->string('slogan_page');
             $table->string('banniere_page');
              $table->text('description_page');
               $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
