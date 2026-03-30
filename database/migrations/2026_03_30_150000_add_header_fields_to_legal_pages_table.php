<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('legal_pages', function (Blueprint $table) {
            $table->string('header_title')->nullable()->after('page');
            $table->string('header_subtitle')->nullable()->after('header_title');
            $table->string('header_background_color', 30)->nullable()->after('header_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('legal_pages', function (Blueprint $table) {
            $table->dropColumn(['header_title', 'header_subtitle', 'header_background_color']);
        });
    }
};
