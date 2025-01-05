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
        $database = DB::getDatabaseName();

        if (str_contains($database, 'sqlite')) {
            DB::statement("
                CREATE VIEW facture_activity_kpi AS
                SELECT
                    status.description,
                    SUM(evenements.prix) AS total_prix
                FROM factures
                JOIN status ON factures.status_id = status.id
                JOIN evenements ON factures.id = evenements.facture_id
                GROUP BY status.description;
            ");
        } elseif (str_contains($database, 'mysql')) {
            DB::statement("
                CREATE VIEW facture_activity_kpi AS
                SELECT
                    status.description,
                    SUM(evenements.prix) AS total_prix
                FROM factures
                JOIN status ON factures.status_id = status.id
                JOIN evenements ON factures.id = evenements.facture_id
                GROUP BY status.description;
            ");
        } elseif (str_contains($database, 'pgsql')) {
            DB::statement("
                CREATE VIEW facture_activity_kpi AS
                SELECT
                    status.description,
                    SUM(evenements.prix) AS total_prix
                FROM factures
                JOIN status ON factures.status_id = status.id
                JOIN evenements ON factures.id = evenements.facture_id
                GROUP BY status.description;
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS facture_activity_kpi');
    }
};
