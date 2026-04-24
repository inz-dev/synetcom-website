<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function dropPk(string $table): void
    {
        DB::statement(<<<SQL
            DO \$\$
            DECLARE c text;
            BEGIN
                SELECT conname INTO c FROM pg_constraint
                WHERE conrelid = '{$table}'::regclass AND contype = 'p';
                IF c IS NOT NULL THEN
                    EXECUTE format('ALTER TABLE {$table} DROP CONSTRAINT %I', c);
                END IF;
            END \$\$
        SQL);
    }

    public function up(): void
    {
        // Drop FK employes → users
        DB::statement('ALTER TABLE "employes" DROP CONSTRAINT IF EXISTS "employes_user_id_foreign"');

        // users.id_user : bigint → varchar(36)
        DB::statement('ALTER TABLE "users" ALTER COLUMN "id_user" TYPE varchar(36) USING "id_user"::varchar');

        // employes.user_id : bigint → varchar(36)
        DB::statement('ALTER TABLE "employes" ALTER COLUMN "user_id" TYPE varchar(36) USING "user_id"::varchar');

        // Spatie model_has_roles.model_id : bigint → varchar(36)
        $this->dropPk('model_has_roles');
        DB::statement('ALTER TABLE "model_has_roles" ALTER COLUMN "model_id" TYPE varchar(36) USING "model_id"::varchar');
        DB::statement('ALTER TABLE "model_has_roles" ADD PRIMARY KEY ("role_id", "model_id", "model_type")');

        // Spatie model_has_permissions.model_id : bigint → varchar(36)
        $this->dropPk('model_has_permissions');
        DB::statement('ALTER TABLE "model_has_permissions" ALTER COLUMN "model_id" TYPE varchar(36) USING "model_id"::varchar');
        DB::statement('ALTER TABLE "model_has_permissions" ADD PRIMARY KEY ("permission_id", "model_id", "model_type")');

        // Re-add FK employes → users
        DB::statement('ALTER TABLE "employes" ADD CONSTRAINT "employes_user_id_foreign" FOREIGN KEY ("user_id") REFERENCES "users"("id_user") ON DELETE SET NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE "employes" DROP CONSTRAINT IF EXISTS "employes_user_id_foreign"');

        $this->dropPk('model_has_roles');
        DB::statement('ALTER TABLE "model_has_roles" ALTER COLUMN "model_id" TYPE bigint USING "model_id"::bigint');
        DB::statement('ALTER TABLE "model_has_roles" ADD PRIMARY KEY ("role_id", "model_id", "model_type")');

        $this->dropPk('model_has_permissions');
        DB::statement('ALTER TABLE "model_has_permissions" ALTER COLUMN "model_id" TYPE bigint USING "model_id"::bigint');
        DB::statement('ALTER TABLE "model_has_permissions" ADD PRIMARY KEY ("permission_id", "model_id", "model_type")');

        DB::statement('ALTER TABLE "employes" ALTER COLUMN "user_id" TYPE bigint USING "user_id"::bigint');
        DB::statement('ALTER TABLE "users" ALTER COLUMN "id_user" TYPE bigint USING "id_user"::bigint');

        DB::statement('ALTER TABLE "employes" ADD CONSTRAINT "employes_user_id_foreign" FOREIGN KEY ("user_id") REFERENCES "users"("id_user") ON DELETE SET NULL');
    }
};
