<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE "employes" DROP CONSTRAINT IF EXISTS "employes_user_id_foreign"');
        DB::statement('ALTER TABLE "users" RENAME COLUMN "id" TO "id_user"');
        DB::statement('ALTER TABLE "employes" ADD CONSTRAINT "employes_user_id_foreign" FOREIGN KEY ("user_id") REFERENCES "users"("id_user") ON DELETE SET NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE "employes" DROP CONSTRAINT IF EXISTS "employes_user_id_foreign"');
        DB::statement('ALTER TABLE "users" RENAME COLUMN "id_user" TO "id"');
        DB::statement('ALTER TABLE "employes" ADD CONSTRAINT "employes_user_id_foreign" FOREIGN KEY ("user_id") REFERENCES "users"("id") ON DELETE SET NULL');
    }
};
