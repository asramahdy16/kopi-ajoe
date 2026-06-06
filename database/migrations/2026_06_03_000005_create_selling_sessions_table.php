<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('selling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users');
            $table->foreignId('motor_id')->constrained('motors');
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->date('session_date');
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->text('seller_notes')->nullable();
            $table->text('manager_notes')->nullable();
            $table->timestamps();

            $table->index('session_date');
            $table->index('status');
            $table->index(['seller_id', 'session_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('selling_sessions');
    }
};
