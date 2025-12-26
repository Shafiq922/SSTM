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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticketID');
            $table->string('ticket_number')->unique();
            $table->string('summary');
            $table->enum('type', ['incident', 'service_request']);
            $table->text('description');

            // Shared lifecycle
            $table->string('priority');
            $table->string('status');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('resolved_at')->nullable();

            // Incident-specific (nullable)
            $table->string('impact_level')->nullable();
            $table->string('urgency')->nullable();

            // Service Request-specific (nullable)
            $table->string('request_type')->nullable();
            $table->string('erp_module')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreignId('assigneeID')->nullable()->constrained('users', 'userID')->nullOnDelete();;
            $table->foreignId('userID')->constrained('users', 'userID')->cascadeOnDelete();
            $table->foreignId('slaID')->constrained('sla', 'slaID');
            $table->foreignId('categoryID')->constrained('categories', 'categoryID');
            $table->foreignId('subCategoryID')->constrained('sub_categories', 'subCategoryID');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
