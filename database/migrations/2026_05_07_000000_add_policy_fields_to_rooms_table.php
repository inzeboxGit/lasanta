<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->text('checkin_info')->nullable()->after('description');
            $table->text('checkout_info')->nullable()->after('checkin_info');
            $table->text('special_instructions')->nullable()->after('checkout_info');
            $table->text('children_policy')->nullable()->after('special_instructions');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['checkin_info', 'checkout_info', 'special_instructions', 'children_policy']);
        });
    }
};
