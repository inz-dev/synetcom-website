<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('name_team')->nullable()->change();
            $table->text('bio_team')->nullable()->after('image_team');
            $table->string('badge_team')->nullable()->after('bio_team');
            $table->string('badge_color_team')->default('#1b449c')->after('badge_team');
            $table->string('id_employe')->nullable()->after('badge_color_team');
            $table->integer('ordre')->default(0)->after('id_employe');
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['bio_team', 'badge_team', 'badge_color_team', 'id_employe', 'ordre']);
            $table->string('name_team')->nullable(false)->change();
        });
    }
};
