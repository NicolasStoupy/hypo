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
        Schema::create('poneys', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50)->unique();
            $table->integer('max_hour_by_day');
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users');
        });

        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('status_id')->constrained('status')->cascadeOnDelete();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50)->unique();
            $table->string('email', 50);
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users');
        });

        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->decimal('prix', 8, 2);
            $table->date('date_evenement');
            $table->integer('nombre_participant');
            $table->string('nom');
            $table->timestamp('date_debut');
            $table->timestamp('date_fin');
            $table->timestamps();
            $table->foreignId('facture_id')->nullable()->constrained('factures');
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('status_id')->constrained('status')->cascadeOnDelete();
        });

        Schema::create('evenement_poneys', function (Blueprint $table) {
            $table->foreignId('evenement_id')->constrained('evenements')->cascadeOnDelete();
            $table->foreignId('poney_id')->constrained('poneys')->cascadeOnDelete();
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users');
            $table->primary(['evenement_id', 'poney_id']);
        });

        Schema::create('status',function (Blueprint $table){
            $table->string('id',10);
            $table->primary('id');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenement_poneys');
        Schema::dropIfExists('evenements');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('factures');
        Schema::dropIfExists('poneys');
    }
};
