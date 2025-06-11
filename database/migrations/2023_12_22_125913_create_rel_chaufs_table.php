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
        Schema::create('rel_chaufs', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli')->nullable();
            $table->integer('RefAppTR')->nullable();
            $table->string('DatRel', 50)->nullable();
            $table->integer('NumRad')->nullable();
            $table->string('NumCal', 12)->nullable();
            $table->decimal('AncIdx', 18, 2)->nullable();
            $table->decimal('NvIdx', 18, 2)->nullable();
            $table->decimal('Coef', 18, 2)->nullable();
            $table->string('Sit', 23)->nullable();
            $table->decimal('NvIdx2', 18, 2)->nullable();
            $table->string('TypCal', 20)->nullable();
            $table->string('Statut', 16)->nullable();
            $table->integer('NumImp')->nullable();
            $table->string('DatImp', 50)->nullable();
            $table->integer('hh_imp')->nullable();
            $table->integer('mm_imp')->nullable();
            $table->tinyInteger('Ok_Site')->nullable();
            $table->timestamps();

            // Clé étrangère
            $table->foreign('Codecli')->references('Codecli')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_chaufs');
    }
};
