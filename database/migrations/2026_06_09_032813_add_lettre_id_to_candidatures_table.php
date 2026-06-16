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
        Schema::table('candidatures', function (Blueprint $table) {
            $table->foreignId('lettre_motivation_id')
                ->nullable()
                ->after('cv_path')
                ->constrained('lettre_motivations')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropForeign(['lettre_motivation_id']);
            $table->dropColumn('lettre_motivation_id');
        });
    }
};
