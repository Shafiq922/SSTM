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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id('attachmentID');
            $table->string('file_path');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('attachments');
    }
};
