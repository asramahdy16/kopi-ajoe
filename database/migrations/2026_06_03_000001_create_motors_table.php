<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('plate_number', 20)->unique();
            $table->string('brand', 50)->nullable();
            $table->integer('battery_capacity')->nullable()->comment('dalam kWh');
            $table->enum('status', ['available', 'in_use', 'maintenance', 'inactive'])->default('available');
            $table->text('condition_notes')->nullable();
            $table->string('photo', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
