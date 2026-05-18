<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('departure_city');
            $table->string('arrival_city');
            $table->dateTime('departure_datetime');
            $table->integer('available_seats');
            $table->decimal('price_per_seat', 8, 2);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'full', 'cancelled', 'completed'])->default('active');
            $table->timestamps();
            
            // Index pour les recherches
            $table->index(['departure_city', 'arrival_city']);
            $table->index('departure_datetime');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};