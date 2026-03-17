<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->string('background_type')->default('video')->after('button_target');
        });
    }

    public function down(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->dropColumn('background_type');
        });
    }
};
