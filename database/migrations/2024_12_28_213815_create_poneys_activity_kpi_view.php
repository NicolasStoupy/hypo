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
        $database = DB::getDatabaseName();

        if (str_contains($database, 'sqlite')) {
            DB::statement("
                CREATE VIEW poneys_activity_kpi AS
                SELECT
                    poneys.nom,
                    strftime('%Y-%W', evenements.date_debut) AS year_week,  -- Année et semaine (SQLite)
                    SUM((julianday(evenements.date_fin) - julianday(evenements.date_debut)) * 24) AS total_hours
                FROM evenements
                JOIN evenement_poneys ON evenements.id = evenement_poneys.evenement_id
                JOIN poneys ON evenement_poneys.poney_id = poneys.id
                GROUP BY poneys.id, year_week
                ORDER BY year_week DESC;
            ");
        } elseif (str_contains($database, 'mysql')) {
            DB::statement("
                CREATE VIEW poneys_activity_kpi AS
                SELECT
                    poneys.nom,
                    DATE_FORMAT(evenements.date_debut, '%Y-%u') AS year_week,  -- Année et semaine (MySQL)
                    SUM(TIMESTAMPDIFF(HOUR, evenements.date_debut, evenements.date_fin)) AS total_hours
                FROM evenements
                JOIN evenement_poneys ON evenements.id = evenement_poneys.evenement_id
                JOIN poneys ON evenement_poneys.poney_id = poneys.id
                GROUP BY poneys.id, year_week
                ORDER BY year_week DESC;
            ");
        } elseif (str_contains($database, 'pgsql')) {
            DB::statement("
                CREATE VIEW poneys_activity_kpi AS
                SELECT
                    poneys.nom,
                    TO_CHAR(evenements.date_debut, 'YYYY-IW') AS year_week,  -- Année et semaine (PostgreSQL)
                    SUM(EXTRACT(EPOCH FROM (evenements.date_fin - evenements.date_debut)) / 3600) AS total_hours
                FROM evenements
                JOIN evenement_poneys ON evenements.id = evenement_poneys.evenement_id
                JOIN poneys ON evenement_poneys.poney_id = poneys.id
                GROUP BY poneys.id, year_week
                ORDER BY year_week DESC;
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS poneys_activity_kpi');
    }
};
