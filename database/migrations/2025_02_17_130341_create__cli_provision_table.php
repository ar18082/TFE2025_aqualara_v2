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
        Schema::create('cli_provisions', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli')->nullable(); // Clé étrangère vers clients
            $table->string('provDtFr')->nullable();
            $table->decimal('montProv', 17, 2)->nullable();
            $table->string('typeCalc')->nullable();
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
        Schema::dropIfExists('cli_provisions');
    }
};
