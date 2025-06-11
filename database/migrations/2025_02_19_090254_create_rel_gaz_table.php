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
        Schema::create('rel_gaz', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli');
            $table->integer('refAppTR');
            $table->date('datRel')->nullable();
            $table->decimal('numCpt', 18, 0)->nullable();
            $table->decimal('ancIdx', 18, 2)->nullable();
            $table->decimal('nvIdx', 18, 2)->nullable();
            $table->string('noCpt')->nullable();
            $table->decimal('nvIdx2', 18, 2)->nullable();
            $table->string('sit')->nullable();
            $table->string('statut')->nullable();
            $table->string('proprioCd')->nullable();
            $table->string('gerantCd')->nullable();
            $table->integer('ok_Site')->nullable();
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_gaz');
    }
};
