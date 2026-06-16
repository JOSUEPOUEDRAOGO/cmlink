<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerte_offres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('toutes_categories')->default(false);
            $table->json('categories_ids')->nullable();
            $table->enum('type_offre', ['stage', 'emploi', 'les_deux'])->default('les_deux');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique('user_id'); // une seule alerte par user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerte_offres');
    }
};
