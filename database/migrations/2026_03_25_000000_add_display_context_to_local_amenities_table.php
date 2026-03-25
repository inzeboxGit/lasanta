<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('local_amenities', function (Blueprint $table) {
            $table->string('display_context', 32)
                ->default('home')
                ->after('link_url');
        });

        $existingItems = DB::table('local_amenities')->get([
            'title',
            'description',
            'image_path',
            'link_url',
            'sort_order',
            'is_published',
            'created_at',
            'updated_at',
        ]);

        foreach ($existingItems as $item) {
            DB::table('local_amenities')->insert([
                'title' => $item->title,
                'description' => $item->description,
                'image_path' => $item->image_path,
                'link_url' => $item->link_url,
                'display_context' => 'restaurant',
                'sort_order' => $item->sort_order,
                'is_published' => $item->is_published,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('local_amenities')
            ->where('display_context', 'restaurant')
            ->delete();

        Schema::table('local_amenities', function (Blueprint $table) {
            $table->dropColumn('display_context');
        });
    }
};
