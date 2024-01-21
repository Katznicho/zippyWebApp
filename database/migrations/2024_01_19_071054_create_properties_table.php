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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string("cover_image")->nullable();
            $table->string("images")->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("owner_id")->constrained("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("agent_id")->nullable()->constrained("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean("is_available")->default(false);
            $table->boolean("is_approved")->default(false);
            $table->integer("number_of_beds")->default(0);
            $table->integer("number_of_baths")->default(0);
            $table->integer("number_of_rooms")->default(0);
            $table->string("room_type")->nullable();
            $table->string("furnishing_status")->nullable();
            $table->string("status");
            $table->string("price")->nullable();
            $table->string("zippy_id")->unique();
            $table->string("currency")->default("UGX");
            $table->string("property_size")->nullable();
            $table->string("year_built")->nullable();
            $table->string("lat")->nullable();
            $table->string("long")->nullable();
            $table->string("location")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
