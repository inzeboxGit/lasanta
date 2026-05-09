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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('tab_key')->unique();   // restaurant, spa, pool, fitness
            $table->string('subtitle')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_text')->nullable();
            $table->string('icon')->nullable();    // FontAwesome class
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
