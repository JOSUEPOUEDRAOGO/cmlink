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
        Schema::table('offres', function (Blueprint $table) {
            $table->unsignedInteger('salaire_min')->nullable()->after('localisation');
            $table->unsignedInteger('salaire_max')->nullable()->after('salaire_min');
            $table->enum('niveau_experience', ['debutant', 'junior', 'intermediaire', 'senior'])->nullable()->after('salaire_max');
            $table->boolean('teletravail')->default(false)->after('niveau_experience');
            $table->unsignedInteger('nb_postes')->default(1)->after('teletravail');
        });
    }

    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            $table->dropColumn(['salaire_min', 'salaire_max', 'niveau_experience', 'teletravail', 'nb_postes']);
        });
    }
};
