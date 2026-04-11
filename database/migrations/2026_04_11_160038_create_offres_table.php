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
    Schema::create('offres', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->text('description');

        $table->enum('type', ['stage', 'emploi']);

        $table->foreignId('entreprise_id')->constrained()->cascadeOnDelete();
        $table->foreignId('categorie_id')->nullable()->constrained()->nullOnDelete();

        $table->string('localisation')->nullable();
        $table->date('date_expiration')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
