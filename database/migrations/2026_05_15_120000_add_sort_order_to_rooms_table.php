<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('gallery');
        });

        $rooms = DB::table('rooms')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get(['id']);

        foreach ($rooms as $index => $room) {
            DB::table('rooms')
                ->where('id', $room->id)
                ->update(['sort_order' => $index + 1]);
        }
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
