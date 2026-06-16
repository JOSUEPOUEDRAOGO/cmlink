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
    Schema::create('offre_competence', function (Blueprint $table) {
        $table->id();
        $table->foreignId('offre_id')->constrained('offres')->cascadeOnDelete();
        $table->foreignId('competence_id')->constrained('competences')->cascadeOnDelete();
        $table->enum('niveau_requis', ['debutant', 'intermediaire', 'avance', 'expert'])->default('debutant');
        $table->boolean('obligatoire')->default(true);
        $table->timestamps();

        $table->unique(['offre_id', 'competence_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('offre_competence');
}
};
