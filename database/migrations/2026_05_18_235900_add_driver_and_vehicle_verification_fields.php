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
            $table->string('license_number')->nullable();
            $table->date('license_issue_date')->nullable();
            $table->string('license_category')->nullable();
            $table->string('license_country')->nullable();
            $table->string('license_photo_recto')->nullable();
            $table->string('license_photo_verso')->nullable();
            $table->string('license_selfie')->nullable();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('year')->nullable();
            $table->string('fuel_type')->nullable();
            $table->decimal('consumption', 8, 2)->nullable();
            $table->string('carte_grise')->nullable();
            $table->string('insurance')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->json('photos')->nullable();
            $table->json('options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'license_number',
                'license_issue_date',
                'license_category',
                'license_country',
                'license_photo_recto',
                'license_photo_verso',
                'license_selfie'
            ]);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'year',
                'fuel_type',
                'consumption',
                'carte_grise',
                'insurance',
                'insurance_expiry',
                'photos',
                'options'
            ]);
        });
    }
};
