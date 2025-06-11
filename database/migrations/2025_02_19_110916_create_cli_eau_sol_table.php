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
        Schema::create('cli_eau_sol', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli');
            $table->string('libelle')->nullable();
            $table->integer('consoMax')->nullable();
            $table->decimal('prixU', 25, 2)->nullable();
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cli_eau_sol');
    }
};
