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
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
        });

        Schema::table('trips', function (Blueprint $table) {
            if (!Schema::hasColumn('trips', 'departure_lat')) {
                $table->decimal('departure_lat', 10, 7)->nullable();
                $table->decimal('departure_lng', 10, 7)->nullable();
                $table->decimal('arrival_lat', 10, 7)->nullable();
                $table->decimal('arrival_lng', 10, 7)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'phone']);
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['departure_lat', 'departure_lng', 'arrival_lat', 'arrival_lng']);
        });
    }
};
