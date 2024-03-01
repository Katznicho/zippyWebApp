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
        Schema::create('property_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('notification_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_enabled')->default(false);
            $table->decimal("match_percentage", 5, 2)->default(0);
            $table->decimal("cost_percentage", 5, 2)->default(0);
            $table->decimal("location_percentage", 5, 2)->default(0);
            $table->decimal("services_percentage", 5, 2)->default(0);
            $table->decimal("amenities_percentage", 5, 2)->default(0);
            $table->decimal("rooms_percentage", 5, 2)->default(0);
            $table->decimal("bathrooms_percentage", 5, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();

            // Indexes for faster lookups
            $table->index(['property_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_notifications');
    }
};
