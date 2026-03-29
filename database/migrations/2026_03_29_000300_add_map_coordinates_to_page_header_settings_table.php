<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $table->decimal('map_latitude', 10, 7)->nullable()->after('availability_text');
            $table->decimal('map_longitude', 10, 7)->nullable()->after('map_latitude');
        });
    }

    public function down(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $table->dropColumn(['map_latitude', 'map_longitude']);
        });
    }
};
