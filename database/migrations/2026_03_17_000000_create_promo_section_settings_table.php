<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique();
            $table->boolean('is_enabled')->default(true);
            $table->string('subtitle')->nullable();
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_section_settings');
    }
};
