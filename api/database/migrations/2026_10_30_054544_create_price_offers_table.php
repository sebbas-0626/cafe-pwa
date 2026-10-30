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
        Schema::create('price_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('buyers');
            $table->foreignId('coffee_variety_id')->constrained('coffee_varieties');
            $table->decimal('price_per_kg', 10, 2);
            $table->string('unit', 20)->default('kg');
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            $table->string('status', 20)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['buyer_id', 'coffee_variety_id', 'status']);
            $table->index('valid_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_offers');
    }
};
