<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->string('rooms_label')->nullable()->after('children_label');
        });
    }

    public function down(): void
    {
        Schema::table('home_hero_settings', function (Blueprint $table) {
            $table->dropColumn('rooms_label');
        });
    }
};
