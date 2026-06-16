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
        Schema::table('etudiants', function (Blueprint $table) {
            $table->date('date_naissance')->nullable()->after('telephone');
            $table->string('ville')->nullable()->after('date_naissance');
            $table->date('disponible_le')->nullable()->after('ville');
            $table->enum('niveau_etudes', ['bac', 'bac+2', 'bac+3', 'bac+5', 'doctorat'])->nullable()->after('disponible_le');
        });
    }

    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropColumn(['date_naissance', 'ville', 'disponible_le', 'niveau_etudes']);
        });
    }
};
