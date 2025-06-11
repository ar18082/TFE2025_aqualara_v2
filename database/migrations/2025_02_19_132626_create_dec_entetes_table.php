<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dec_entetes', function (Blueprint $table) {
            $table->id();
            $table->string('chfConsCom')->nullable();
            $table->string('chfNbQuot')->nullable();
            $table->string('chfPUQuot')->nullable();
            $table->string('chfConsPrive')->nullable();
            $table->string('chfNbDiv')->nullable();
            $table->string('chfPUDiv')->nullable();
            $table->string('eauUnit')->nullable();
            $table->string('eauCCons')->nullable();
            $table->string('eauCm3')->nullable();
            $table->string('eauCPU')->nullable();
            $table->string('eauFCons')->nullable();
            $table->string('eauFm3')->nullable();
            $table->string('eauFPU')->nullable();
            $table->string('gazCons')->nullable();
            $table->string('gazm3')->nullable();
            $table->string('gazPU')->nullable();
            $table->string('elecCons')->nullable();
            $table->string('elecKW')->nullable();
            $table->string('elecPU')->nullable();
            $table->string('chfFrRel')->nullable();
            $table->string('chfNbRel')->nullable();
            $table->string('chfPURel')->nullable();
            $table->string('eauCFrRel')->nullable();
            $table->string('eauCNbRel')->nullable();
            $table->string('eauCPURel')->nullable();
            $table->string('eauFFrRel')->nullable();
            $table->string('eauFNbRel')->nullable();
            $table->string('gazFrRel')->nullable();
            $table->string('gazNbRel')->nullable();
            $table->string('gazPURel')->nullable();
            $table->string('elecFrRel')->nullable();
            $table->string('elecNbRel')->nullable();
            $table->string('elecPURel')->nullable();
            $table->string('FrDiv')->nullable();
            $table->string('FrDivNb')->nullable();
            $table->string('FrDivPU')->nullable();
            $table->string('chfFrAnnLib')->nullable();
            $table->string('chfFrAnn')->nullable();
            $table->string('chfFrAnnNb')->nullable();
            $table->string('chfFrAnnPU')->nullable();
            $table->string('eauFrAnnLib')->nullable();
            $table->string('eauFrAnn')->nullable();
            $table->string('eauFrAnnNb')->nullable();
            $table->string('eauFrAnnPU')->nullable();
            $table->string('gazFrAnnLib')->nullable();
            $table->string('gazFrAnn')->nullable();
            $table->string('gazFrAnnNb')->nullable();
            $table->string('gazFrAnnPU')->nullable();
            $table->string('elecFrAnnLib')->nullable();
            $table->string('elecFrAnn')->nullable();
            $table->string('elecFrAnnNb')->nullable();
            $table->string('elecFrAnnPU')->nullable();
            $table->string('provTotCle')->nullable();
            $table->string('Codecli')->nullable();
            $table->string('debPer')->nullable();
            $table->string('finPer')->nullable();
            $table->string('statut')->nullable();
            $table->string('chfFrDiv')->nullable();
            $table->string('eauFrDiv')->nullable();
            $table->string('gazFrDiv')->nullable();
            $table->string('elecFrDiv')->nullable();
            $table->string('typCalc')->nullable();
            $table->string('eauSol')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dec_entetes');
    }
};
