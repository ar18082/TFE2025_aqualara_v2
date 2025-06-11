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
        Schema::create('clichaufs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable(); // Clé étrangère
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');

            $table->integer('Codecli')->nullable();
            $table->integer('Quotite')->nullable();
            $table->decimal('PctPrive', 18, 2)->nullable();
            $table->decimal('PctCom', 18, 2)->nullable();
            $table->string('TypCal', 200)->nullable();
            $table->decimal('FraisTR', 18, 8)->nullable();
            $table->decimal('FraisAnn', 18, 2)->nullable();
            $table->decimal('Consom', 18, 2)->nullable();
            $table->string('Periode', 100)->nullable();
            $table->integer('UniteAnn')->nullable();
            $table->string('TypRep', 16)->nullable();
            $table->decimal('ConsPrive', 18, 2)->nullable();
            $table->decimal('ConsComm', 18, 2)->nullable();
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
        Schema::dropIfExists('clichaufs');
    }
};
