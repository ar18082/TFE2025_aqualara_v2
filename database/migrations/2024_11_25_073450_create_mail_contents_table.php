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
        Schema::create('mail_contents', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('content');
            $table->foreignId('type_event_id')->nullable()->constrained('type_events')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_contents', function (Blueprint $table) {
            $table->dropForeign(['type_event_id']);
            $table->dropColumn('type_event_id');
        });
    }
};
