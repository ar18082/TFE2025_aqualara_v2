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
        //        TABLE: App-Proprio
        //Codecli	decimal(18, 0)	 nullable
        //RefAppTR	int	 nullable
        //Propriocd	varchar(16)	 nullable
        //DatDeb	varchar(50)	 nullable
        //DatFin	varchar(50)	 nullable
        Schema::create('app_proprios', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli')->nullable();
            $table->integer('RefAppTR')->nullable();
            $table->string('Propriocd', 16);
            $table->string('DatDeb')->nullable();
            $table->string('DatFin')->nullable();
            $table->timestamps();

            $table->foreign('Codecli')->references('Codecli')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_proprios');
    }
};
