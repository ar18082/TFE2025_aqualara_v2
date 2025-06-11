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
        Schema::table('techniciens', function (Blueprint $table) {
            $table->string('registre_national')->nullable();
            $table->string('rue')->nullable();
            $table->string('numero')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('localite')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('techniciens', function (Blueprint $table) {
            $table->dropColumn(['registre_national', 'rue', 'numero', 'code_postal', 'localite']);
        });
    }
};
