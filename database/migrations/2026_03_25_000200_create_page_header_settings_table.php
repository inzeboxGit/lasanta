<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_header_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page')->unique();
            $table->string('header_image')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('title')->nullable();
            $table->text('hero_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_header_settings');
    }
};
