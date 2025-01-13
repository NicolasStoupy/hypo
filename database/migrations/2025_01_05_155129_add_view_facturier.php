<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Création de la vue 'facturier'
        DB::statement("
            CREATE VIEW facturier AS
            SELECT
                CAST(strftime('%Y', evenements.date_debut) AS INTEGER) AS year,
                CAST(strftime('%m', evenements.date_debut) AS INTEGER) AS month,
                ROUND(SUM(prix), 2) AS revenu
            FROM evenements
            GROUP BY year, month;
        ");

        // Création de la vue 'facturier_client'
        DB::statement("
            CREATE VIEW facturier_client AS
            SELECT
                CAST(strftime('%Y', evenements.date_debut) AS INTEGER) AS year,
                CAST(strftime('%m', evenements.date_debut) AS INTEGER) AS month,
                c.id,
                c.nom,
                ROUND(SUM(prix), 2) AS revenu,
                 count(*) as totalevenement
            FROM evenements
            JOIN clients c ON evenements.client_id = c.id
            GROUP BY year, month, c.id;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les vues lors du rollback de la migration
        DB::statement('DROP VIEW IF EXISTS facturier');
        DB::statement('DROP VIEW IF EXISTS facturier_client');
    }
};
