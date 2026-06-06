<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->unique()->constrained('menus')->cascadeOnDelete();
            $table->integer('current_stock')->default(0);
            $table->integer('low_stock_threshold')->default(10)->comment('Alert ketika stok di bawah angka ini');
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_stocks');
    }
};
