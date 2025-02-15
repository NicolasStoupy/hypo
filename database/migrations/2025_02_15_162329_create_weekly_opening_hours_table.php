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
        Schema::create('weekly_opening_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('week_number'); // Numéro de la semaine (1-52)
            $table->year('year'); // Année concernée
            $table->integer('day'); // Lundi = 1, Mardi =2 ...
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_opening_hours');
    }
};
