<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_logs', function (Blueprint $table) {
            $table->id('ticketLogID');
            $table->string('action');
            $table->text('description');
            $table->timestamps();

            $table->foreignId('ticketID')->constrained('tickets', 'ticketID')->onDelete('cascade');
            $table->foreignId('userID')->constrained('users', 'userID')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_logs');
    }
};
