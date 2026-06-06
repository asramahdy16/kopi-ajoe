<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus');
            $table->foreignId('manager_id')->constrained('users');
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->date('entry_date');
            $table->timestamp('created_at')->nullable();

            $table->index('entry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
    }
};
