<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('selling_sessions')->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained('menus');
            $table->integer('qty_requested');
            $table->integer('qty_approved')->nullable();
            $table->integer('qty_remaining')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_stocks');
    }
};
