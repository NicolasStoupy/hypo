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
        Schema::table('cavaliers', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->default(0);
            $table->foreignId('facture_id')->nullable()->constrained('factures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cavaliers', function (Blueprint $table) {
            $table->dropForeign(['facture_id']); // Supprime la contrainte de clé étrangère
            $table->dropColumn(['amount', 'facture_id']); // Supprime les colonnes amount et facture_id
        });
    }
};
