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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->string('secteur')->nullable()->after('adresse');
            $table->enum('taille', ['1-10', '11-50', '51-200', '201-500', '500+'])->nullable()->after('secteur');
            $table->string('site_web')->nullable()->after('taille');
            $table->string('logo')->nullable()->after('site_web');
            $table->text('description')->nullable()->after('logo');
        });
    }

    public function down(): void
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn(['secteur', 'taille', 'site_web', 'logo', 'description']);
        });
    }
};
