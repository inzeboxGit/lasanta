<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('about_section_settings', 'button_text')) {
                $table->string('button_text')->nullable()->after('signature');
            }

            if (!Schema::hasColumn('about_section_settings', 'button_link')) {
                $table->string('button_link')->nullable()->after('button_text');
            }

            if (!Schema::hasColumn('about_section_settings', 'button_target')) {
                $table->string('button_target')->default('_self')->after('button_link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            $columns = ['button_text', 'button_link', 'button_target'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('about_section_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
