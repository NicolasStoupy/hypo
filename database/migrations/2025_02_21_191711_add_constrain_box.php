<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Supprimer la vue avant de modifier la table
        DB::statement('DROP VIEW IF EXISTS poneys_activity_kpi');


        Schema::table('poneys', function (Blueprint $table) {
            $table->foreignId('box_id')->nullable()->constrained('boxs')->nullOnDelete();
        });

        // La vue sera recréée après la migration
        Artisan::call('migrate:refresh --path=/database/migrations/2024_12_28_213815_create_poneys_activity_kpi_view.php');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('poneys', function (Blueprint $table) {
            $table->dropForeign(['box_id']); // Supprime la contrainte de clé étrangère
            $table->dropColumn('box_id'); // Supprime la colonne 'box_id'
        });
    }
};
