<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('local_amenity_section_settings', function (Blueprint $table) {
            $table->string('header_image')->nullable()->after('section');
        });
    }

    public function down(): void
    {
        Schema::table('local_amenity_section_settings', function (Blueprint $table) {
            $table->dropColumn('header_image');
        });
    }
};
