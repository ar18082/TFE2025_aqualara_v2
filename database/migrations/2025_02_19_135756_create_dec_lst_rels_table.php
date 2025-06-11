<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dec_lst_rels', function (Blueprint $table) {
            $table->id();
            $table->integer('refAppTR')->nullable();
            $table->integer('Codecli')->nullable();
            $table->string('datRelChf')->nullable();
            $table->string('datRelEau')->nullable();
            $table->string('datRelGaz')->nullable();
            $table->string('datRelElec')->nullable();
            $table->string('rmqOcc')->nullable();
            $table->string('debPer')->nullable();
            $table->string('finPer')->nullable();
            $table->timestamps();

            // Add foreign keys
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dec_lst_rels');
    }
};
