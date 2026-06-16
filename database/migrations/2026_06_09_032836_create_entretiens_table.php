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
    Schema::create('entretiens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('candidature_id')->constrained('candidatures')->cascadeOnDelete();
        $table->dateTime('date_rdv');
        $table->enum('type', ['presentiel', 'visio', 'telephonique'])->default('presentiel');
        $table->enum('statut', ['planifie', 'confirme', 'annule', 'effectue'])->default('planifie');
        $table->string('lien_visio')->nullable(); // pour les entretiens en visio
        $table->string('adresse')->nullable();    // pour les entretiens en présentiel
        $table->text('notes')->nullable();
        $table->text('resultat')->nullable();     // feedback post-entretien
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('entretiens');
}
};
