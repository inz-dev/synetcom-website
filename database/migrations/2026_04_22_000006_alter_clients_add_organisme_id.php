<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignUuid('id_organisme')->nullable()->after('est_partenaire_client')
                  ->references('id_organisme')->on('organismes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['id_organisme']);
            $table->dropColumn('id_organisme');
        });
    }
};
