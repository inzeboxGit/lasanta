<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promo_section_settings', function (Blueprint $table) {
            $table->dropUnique('promo_section_settings_section_unique');
        });
    }

    public function down(): void
    {
        Schema::table('promo_section_settings', function (Blueprint $table) {
            $table->unique('section');
        });
    }
};
