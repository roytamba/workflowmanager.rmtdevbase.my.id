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
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->enum('project_type', ['web', 'desktop', 'mobile', 'embedded'])->nullable();
            $table->enum('status', ['draft', 'in_progress', 'completed', 'on_hold', 'cancelled'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('deployment_status', ['none', 'uat', 'live'])->default('none');
            $table->string('uat_link')->nullable();
            $table->string('live_link')->nullable();
            $table->string('checkout_link')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_details');
    }
};
