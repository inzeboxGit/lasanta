<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $table->string('info_booking_label')->nullable()->after('availability_text');
            $table->string('select_room_label')->nullable()->after('info_booking_label');
            $table->string('adults_label')->nullable()->after('select_room_label');
            $table->string('children_label')->nullable()->after('adults_label');
            $table->string('book_now_label')->nullable()->after('children_label');
            $table->string('calendar_night_label')->nullable()->after('book_now_label');
            $table->string('calendar_nights_label')->nullable()->after('calendar_night_label');
        });
    }

    public function down(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $table->dropColumn([
                'info_booking_label',
                'select_room_label',
                'adults_label',
                'children_label',
                'book_now_label',
                'calendar_night_label',
                'calendar_nights_label',
            ]);
        });
    }
};
