<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('subtitle')->default('Questions fréquentes');
            $table->string('title')->default('FAQ');
            $table->text('description')->nullable();
            $table->string('button_label')->nullable();
            $table->string('button_link')->nullable();
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('faq_section_settings');
    }
};
