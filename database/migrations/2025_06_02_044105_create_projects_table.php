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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_name')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['In Progress', 'Completed', 'On Hold', 'Cancelled'])->default('In Progress');
            $table->decimal('budget', 12, 2)->default(0);
            $table->integer('total_tasks')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('progress')->default(0);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by');

            // Kolom tambahan UAT / Live info
            $table->enum('deployment_status', ['None', 'UAT', 'Live'])->default('None');
            $table->string('uat_link')->nullable();
            $table->string('live_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
