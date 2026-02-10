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
        Schema::create('service_ratings', function (Blueprint $table) {
            $table->id('ratingID');
            $table->foreignId('rater_userID')->constrained('users', 'userID')->cascadeOnDelete();
            $table->foreignId('ratee_userID')->constrained('users', 'userID')->cascadeOnDelete();
            $table->foreignId('ticketID')->nullable()->constrained('tickets', 'ticketID')->nullOnDelete(); // Optional linking
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_ratings');
    }
};
