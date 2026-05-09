<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->string('check_in_label')->nullable()->after('dates_label');
            $table->string('check_out_label')->nullable()->after('check_in_label');
        });
    }

    public function down(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->dropColumn(['check_in_label', 'check_out_label']);
        });
    }
};
