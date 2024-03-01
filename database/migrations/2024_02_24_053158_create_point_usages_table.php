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
        Schema::create('point_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('property_id')->nullable()->references('id')->on('properties');
            $table->foreignId('booking_id')->nullable()->references('id')->on('bookings');
            $table->foreignId("property_notification_id")->nullable()->references('id')->on('property_notifications');
            $table->string('points');
            $table->string("reason")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_usages');
    }
};
