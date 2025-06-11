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
        //        Codecli	decimal(18, 0)	Checked
        //RefAppTR	int	Checked
        //DatRel	varchar(50)	Checked
        //MtProv	decimal(18, 2)	Checked
        //CleProv	decimal(18, 2)	Checked
        //ProprioCd	varchar(50)	Checked
        //LocatCd	varchar(46)	Checked

        Schema::create('rel_apps', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli')->nullable();
            $table->integer('RefAppTR')->nullable();
            $table->string('DatRel')->nullable();
            $table->decimal('MtProv', 18, 2)->nullable();
            $table->decimal('CleProv', 18, 2)->nullable();
            $table->string('ProprioCd')->nullable();
            $table->string('LocatCd')->nullable();
            $table->index(['Codecli', 'RefAppTR', 'DatRel']);
            $table->timestamps();
        });

        Schema::table('rel_apps', function (Blueprint $table) {
            $table->foreign('Codecli')->references('Codecli')->on('clients');
            //            $table->foreign('RefAppTR')->references('RefAppTR')->on('appartements');
            //            $table->foreign('ProprioCd')->references('Propriocd')->on('app_proprios');
            //            $table->foreign('LocatCd')->references('Locatcd')->on('locataires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_apps');
    }
};
