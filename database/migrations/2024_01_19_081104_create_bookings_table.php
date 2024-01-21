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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_approved')->default(false);
            $table->date('check_in_date');
            $table->date('check_out_date')->nullable();
            $table->integer('duration_in_days');
            $table->integer('total_price')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId("payment_id")->nullable()->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
