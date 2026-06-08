<!-- 2026_05_24_134815_create_lettre_motivations_table.php -->
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lettre_motivations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('etudiant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('titre');

            $table->longText('contenu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lettre_motivations');
    }
};
