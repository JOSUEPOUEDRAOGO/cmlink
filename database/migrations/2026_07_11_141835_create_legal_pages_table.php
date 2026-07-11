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
        Schema::create('legal_pages', function (Blueprint $table) {

            $table->id();

            // Nom affiché de la page
            $table->string('title');

            // Identifiant URL : cgu, pdc, support...
            $table->string('slug')->unique();

            // Contenu HTML éditable depuis le back-office
            $table->longText('content');

            // Page active ou désactivée
            $table->boolean('status')->default(true);

            // Administrateur qui a créé la page
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Administrateur qui a effectué la dernière modification
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_pages');
    }
};
