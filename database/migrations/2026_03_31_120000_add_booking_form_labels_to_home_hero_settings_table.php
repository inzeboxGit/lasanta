<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->string('dates_label')->nullable()->after('title');
            $table->string('adults_label')->nullable()->after('dates_label');
            $table->string('children_label')->nullable()->after('adults_label');
            $table->string('search_label')->nullable()->after('children_label');
        });
    }

    public function down(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->dropColumn(['dates_label', 'adults_label', 'children_label', 'search_label']);
        });
    }
};
