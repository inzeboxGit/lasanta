<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('about_section_settings', 'third_image')) {
                $table->string('third_image')->nullable()->after('overlay_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            if (Schema::hasColumn('about_section_settings', 'third_image')) {
                $table->dropColumn('third_image');
            }
        });
    }
};