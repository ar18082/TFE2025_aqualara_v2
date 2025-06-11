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
        Schema::dropIfExists('cli_elecs');

        Schema::create('cli_elecs', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli'); // Clé étrangère vers clients
            $table->decimal('prix', 10, 2);
            $table->string('typCpt');
            $table->decimal('fraisTR', 10, 2)->nullable();
            $table->decimal('fraisAnn', 10, 2)->nullable();
            $table->integer('consom'); // Type corrigé
            $table->string('periode');
            $table->integer('typcalc'); // Type corrigé
            $table->decimal('UnitAnn', 10, 2)->nullable(); // Suppression de l'auto-increment
            $table->timestamps();

            // Relation avec clients
            $table->foreign('Codecli')->references('Codecli')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cli_elecs');
    }
};
