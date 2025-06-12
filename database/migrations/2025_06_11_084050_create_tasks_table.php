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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Relasi manual (tanpa foreign key constraint)
            $table->unsignedBigInteger('project_id')->nullable();      // Proyek terkait
            $table->unsignedBigInteger('assigned_to')->nullable();     // User yang ditugaskan
            $table->unsignedBigInteger('created_by')->nullable();      // User pembuat task
            $table->unsignedBigInteger('parent_task_id')->nullable();  // Untuk subtask

            // Informasi utama task
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('module')->nullable();                      // Nama modul terkait (optional)

            // Waktu dan Deadline
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('completed_at')->nullable();

            // Status dan Prioritas
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'on_hold', 'cancelled'])
                ->default('not_started');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');

            $table->string('tags')->nullable();

            // Lain-lain
            $table->boolean('is_approved')->default(false);
            $table->text('notes')->nullable();

            // Soft delete & timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
