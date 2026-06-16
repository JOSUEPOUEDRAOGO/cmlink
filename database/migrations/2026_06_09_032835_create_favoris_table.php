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
    Schema::create('favoris', function (Blueprint $table) {
        $table->id();
        $table->foreignId('etudiant_id')->constrained('etudiants')->cascadeOnDelete();
        $table->foreignId('offre_id')->constrained('offres')->cascadeOnDelete();
        $table->timestamps();

        $table->unique(['etudiant_id', 'offre_id']); // pas de doublon
    });
}

public function down(): void
{
    Schema::dropIfExists('favoris');
}
};
