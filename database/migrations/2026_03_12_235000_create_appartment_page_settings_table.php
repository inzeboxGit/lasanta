<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appartment_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page')->unique();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('header_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appartment_page_settings');
    }
};
