<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appartment_page_settings', function (Blueprint $table) {
            $table->text('home_description')->nullable()->after('home_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('appartment_page_settings', function (Blueprint $table) {
            $table->dropColumn('home_description');
        });
    }
};
