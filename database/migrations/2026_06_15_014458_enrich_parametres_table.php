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
        Schema::table('parametres', function (Blueprint $table) {
            $table->string('groupe')->default('general')->after('cle');
            $table->string('type')->default('text')->after('valeur'); // text, boolean, number, select, json
            $table->string('label')->nullable()->after('type');
            $table->text('description')->nullable()->after('label');
            $table->text('options')->nullable()->after('description'); // pour les selects (JSON)
            $table->boolean('is_public')->default(false)->after('options');
            $table->boolean('is_locked')->default(false)->after('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
