<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('id');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->string('id_team', 36)->primary()->first();
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('id_team');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });
    }
};
