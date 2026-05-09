<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'front_theme')) {
                $table->string('front_theme', 64)->default('default')->after('default_locale');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_settings') || ! Schema::hasColumn('site_settings', 'front_theme')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('front_theme');
        });
    }
};
