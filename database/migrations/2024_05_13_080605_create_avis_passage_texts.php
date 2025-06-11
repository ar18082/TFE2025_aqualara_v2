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
        Schema::create('avis_passage_texts', function (Blueprint $table) {
            $table->id();
            $table->string('typePassage')->nullable();
            $table->string('acces')->nullable();
            $table->string('presence')->nullable();
            $table->string('coupure')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis_passage_texts');
    }
};
