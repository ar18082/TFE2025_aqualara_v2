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
        Schema::table('avis_passage_texts', function (Blueprint $table) {
            $table->foreignId('type_event_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('avis_passage_texts', function (Blueprint $table) {
            $table->dropForeign(['type_event_id']);
            $table->dropColumn('type_event_id');
        });
    }
};
