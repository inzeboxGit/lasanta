<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appartment_page_settings', function (Blueprint $table) {
            $table->string('home_title')->nullable()->after('subtitle');
            $table->string('home_subtitle')->nullable()->after('home_title');
        });
    }

    public function down(): void
    {
        Schema::table('appartment_page_settings', function (Blueprint $table) {
            $table->dropColumn(['home_title', 'home_subtitle']);
        });
    }
};
