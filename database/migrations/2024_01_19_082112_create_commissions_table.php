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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('property_id')->nullable()->constrained('properties')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('amount'); // The commission amount
            $table->string('currency')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
