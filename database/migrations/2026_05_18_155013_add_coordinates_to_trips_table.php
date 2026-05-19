<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('start_lat', 10, 8)->nullable()->after('departure_city');
            $table->decimal('start_lng', 11, 8)->nullable()->after('start_lat');
            $table->decimal('end_lat', 10, 8)->nullable()->after('arrival_city');
            $table->decimal('end_lng', 11, 8)->nullable()->after('end_lat');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['start_lat', 'start_lng', 'end_lat', 'end_lng']);
        });
    }
};
