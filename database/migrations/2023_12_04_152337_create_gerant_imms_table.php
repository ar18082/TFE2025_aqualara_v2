<?php

use App\Models\Contact;
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
        //        Codegerant	varchar(20)	Checked
        //        DatDeb	varchar(50)	Checked
        //        Acces	tinyint	Checked
        //        DatFin	varchar(50)	Checked
        // check if nullable
        Schema::create('gerant_imms', function (Blueprint $table) {
            $table->id();
            $table->integer('Codecli')->nullable();
            $table->string('codegerant', 16);
            $table->string('datdeb', 50)->nullable();
            $table->tinyInteger('acces')->nullable();
            $table->string('datfin', 50)->nullable();
            $table->timestamps();

            //            $table->foreignIdFor(Contact::class, 'codegerant')->nullable()->constrained('contacts')->onDelete('cascade');
            $table->foreign('Codecli')->references('Codecli')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerant_imms');
    }
};
