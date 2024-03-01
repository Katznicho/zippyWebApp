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
        Schema::create('zippy_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("Zippy Alert");
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("category_id")->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text("services");
            $table->text("amenities");
            $table->string("minimum_price");
            $table->string("maximum_price");
            $table->string("contact_options");
            $table->string("number_of_bedrooms");
            $table->string("number_bathrooms");
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zippy_alerts');
    }
};
