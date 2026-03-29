<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $table->string('availability_small')->nullable()->after('hero_text');
            $table->string('availability_title')->nullable()->after('availability_small');
            $table->text('availability_text')->nullable()->after('availability_title');
        });
    }

    public function down(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $table->dropColumn(['availability_small', 'availability_title', 'availability_text']);
        });
    }
};
