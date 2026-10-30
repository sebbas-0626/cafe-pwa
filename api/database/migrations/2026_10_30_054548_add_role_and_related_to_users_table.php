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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 30)->default('farmer')->after('password');
            $table->string('phone', 30)->nullable()->after('role');
            $table->boolean('is_verified')->default(false)->after('phone');
            $table->foreignId('buyer_id')->nullable()->after('is_verified')->constrained('buyers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('buyer_id');
            $table->dropColumn(['role', 'phone', 'is_verified']);
        });
    }
};
