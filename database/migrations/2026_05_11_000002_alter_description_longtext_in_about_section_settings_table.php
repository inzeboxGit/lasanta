<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            $table->longText('description')->change();
        });
    }

    public function down(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            $table->string('description', 255)->change(); // Remettre comme avant si besoin
        });
    }
};
