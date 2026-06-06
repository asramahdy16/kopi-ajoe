<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->unique()->constrained('selling_sessions')->comment('Satu sesi = satu record upah');
            $table->foreignId('seller_id')->constrained('users');
            $table->decimal('base_salary', 12, 2)->default(0);
            $table->decimal('total_sales', 12, 2)->default(0);
            $table->decimal('commission', 12, 2)->default(0);
            $table->decimal('total_salary', 12, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('seller_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_records');
    }
};
