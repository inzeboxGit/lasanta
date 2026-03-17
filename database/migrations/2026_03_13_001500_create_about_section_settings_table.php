<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique();
            $table->string('small_title')->nullable();
            $table->string('title')->nullable();
            $table->string('lead')->nullable();
            $table->text('description')->nullable();
            $table->string('signature')->nullable();
            $table->string('main_image')->nullable();
            $table->string('overlay_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_section_settings');
    }
};
