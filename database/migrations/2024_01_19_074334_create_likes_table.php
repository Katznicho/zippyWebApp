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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('comment_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_like')->default(false);
            $table->boolean('is_dislike')->default(false);
            $table->integer('count')->default(0);
            $table->integer('rating')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
