<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('local_amenity_section_settings', function (Blueprint $table) {
            $table->text('hero_text')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('local_amenity_section_settings', function (Blueprint $table) {
            $table->dropColumn('hero_text');
        });
    }
};
