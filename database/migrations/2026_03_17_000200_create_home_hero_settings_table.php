<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique();
            $table->boolean('show_booking_form')->default(true);
            $table->string('small_title')->nullable();
            $table->string('title')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_target')->default('_self');
            $table->string('background_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_hero_settings');
    }
};
