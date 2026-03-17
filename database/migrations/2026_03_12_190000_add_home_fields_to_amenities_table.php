<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('amenities', function (Blueprint $table) {
            $table->text('description')->nullable()->after('icon');
            $table->string('image_path')->nullable()->after('description');
            $table->string('scope')->default('room')->after('image_path');
            $table->unsignedInteger('sort_order')->default(0)->after('scope');
            $table->boolean('is_published')->default(true)->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('amenities', function (Blueprint $table) {
            $table->dropColumn(['description', 'image_path', 'scope', 'sort_order', 'is_published']);
        });
    }
};
