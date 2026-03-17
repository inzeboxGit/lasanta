<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->string('background_video')->nullable()->after('background_type');
            $table->string('youtube_video_url')->nullable()->after('background_video');
        });
    }

    public function down(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->dropColumn(['background_video', 'youtube_video_url']);
        });
    }
};
