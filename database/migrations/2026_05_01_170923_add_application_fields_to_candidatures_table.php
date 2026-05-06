<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->string('nom')->nullable()->after('id');
            $table->string('email')->nullable()->after('nom');
            $table->string('telephone')->nullable()->after('email');
            $table->text('message')->nullable()->after('telephone');
            $table->string('cv_path')->nullable()->after('message');

            $table->foreignId('etudiant_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn([
                'nom',
                'email',
                'telephone',
                'message',
                'cv_path',
            ]);

            $table->foreignId('etudiant_id')->nullable(false)->change();
        });
    }
};
