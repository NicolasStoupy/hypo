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
        DB::statement("
            CREATE VIEW view_availaibility AS
            SELECT
                box_id,
                date_debut AS debut,
                date_fin AS fin
            FROM evenements
            JOIN evenement_poneys ON evenements.id = evenement_poneys.evenement_id
            JOIN poneys ON evenement_poneys.poney_id = poneys.id
            WHERE date_evenement = CURRENT_DATE
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_availaibility");
    }
};
