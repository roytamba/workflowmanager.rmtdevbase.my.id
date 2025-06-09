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
        Schema::create('user_designations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');     // tanpa foreign key constraint
            $table->unsignedBigInteger('role_id');     // tanpa foreign key constraint
            $table->unsignedBigInteger('position_id'); // tanpa foreign key constraint
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_designations');
    }
};
