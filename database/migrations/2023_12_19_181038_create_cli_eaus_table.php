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
        Schema::create('cli_eaus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable(); // Clé étrangère
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->integer('Codecli')->nullable();
            $table->decimal('PrxFroid', 18, 4)->nullable();
            $table->decimal('PrxChaud', 18, 4)->nullable();
            $table->string('TypCpt', 100)->nullable();
            $table->decimal('FraisTR', 18, 2)->nullable();
            $table->decimal('FraisAnn', 18, 2)->nullable();
            $table->decimal('Consom', 18, 2)->nullable();
            $table->tinyInteger('Unite')->nullable();
            $table->decimal('SupChaud', 18, 2)->nullable();
            $table->string('Periode', 100)->nullable();
            $table->tinyInteger('typcalc_')->nullable();
            $table->integer('UnitAnn')->nullable();
            $table->string('typcalc', 16)->nullable();
            $table->tinyInteger('ChaudChf')->nullable();
            $table->tinyInteger('EauSol')->nullable();
            $table->string('TypRlv', 8)->nullable();
            $table->string('DatePlacement', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cli_eaus');
    }
};
