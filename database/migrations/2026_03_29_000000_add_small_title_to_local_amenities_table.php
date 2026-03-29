<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('local_amenities', function (Blueprint $table) {
            $table->string('small_title')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('local_amenities', function (Blueprint $table) {
            $table->dropColumn('small_title');
        });
    }
};
