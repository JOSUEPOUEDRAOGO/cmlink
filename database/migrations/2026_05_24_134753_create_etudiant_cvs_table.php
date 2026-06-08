<!-- 2026_05_24_134753_create_etudiant_cvs_table.php -->

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiant_cvs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('etudiant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('titre');

            $table->string('cv_path');

            $table->boolean('principal')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiant_cvs');
    }
};
