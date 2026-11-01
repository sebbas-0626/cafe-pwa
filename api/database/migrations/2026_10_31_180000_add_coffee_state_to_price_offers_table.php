<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_offers', function (Blueprint $table) {
            if (! Schema::hasColumn('price_offers', 'coffee_state')) {
                $table->string('coffee_state', 30)->default('pergamino_seco')->after('coffee_variety_id')->index();
            }

            if (! Schema::hasColumn('price_offers', 'moisture_required')) {
                $table->decimal('moisture_required', 5, 2)->nullable()->after('price_per_kg');
            }

            if (! Schema::hasColumn('price_offers', 'yield_factor')) {
                $table->decimal('yield_factor', 5, 2)->nullable()->after('moisture_required');
            }
        });
    }

    public function down(): void
    {
        Schema::table('price_offers', function (Blueprint $table) {
            if (Schema::hasColumn('price_offers', 'yield_factor')) {
                $table->dropColumn('yield_factor');
            }

            if (Schema::hasColumn('price_offers', 'moisture_required')) {
                $table->dropColumn('moisture_required');
            }

            if (Schema::hasColumn('price_offers', 'coffee_state')) {
                $table->dropColumn('coffee_state');
            }
        });
    }
};
