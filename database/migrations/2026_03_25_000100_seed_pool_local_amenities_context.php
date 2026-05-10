<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('local_amenities')) {
            return;
        }

        $hasPoolItems = DB::table('local_amenities')
            ->where('display_context', 'pool')
            ->exists();

        if (! $hasPoolItems) {
            $restaurantItems = DB::table('local_amenities')
                ->where('display_context', 'restaurant')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get([
                    'title',
                    'description',
                    'image_path',
                    'link_url',
                    'sort_order',
                    'is_published',
                    'created_at',
                    'updated_at',
                ]);

            foreach ($restaurantItems as $item) {
                DB::table('local_amenities')->insert([
                    'title' => $item->title,
                    'description' => $item->description,
                    'image_path' => $item->image_path,
                    'link_url' => $item->link_url,
                    'display_context' => 'pool',
                    'sort_order' => $item->sort_order,
                    'is_published' => $item->is_published,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]);
            }
        }

        if (! Schema::hasTable('local_amenity_section_settings')) {
            return;
        }

        $hasPoolSection = DB::table('local_amenity_section_settings')
            ->where('section', 'about_pool_amenities')
            ->exists();

        if ($hasPoolSection) {
            return;
        }

        $restaurantSection = DB::table('local_amenity_section_settings')
            ->where('section', 'about_local_amenities')
            ->first([
                'header_image',
                'subtitle',
                'title',
                'created_at',
                'updated_at',
            ]);

        DB::table('local_amenity_section_settings')->insert([
            'section' => 'about_pool_amenities',
            'header_image' => $restaurantSection?->header_image ?? 'img/home_2.jpg',
            'subtitle' => $restaurantSection?->subtitle ?? 'RÉsidence Hotel La Santa',
            'title' => 'Piscine',
            'created_at' => $restaurantSection?->created_at ?? now(),
            'updated_at' => $restaurantSection?->updated_at ?? now(),
        ]);
    }

    public function down(): void
    {
        if (Schema::hasTable('local_amenity_section_settings')) {
            DB::table('local_amenity_section_settings')
                ->where('section', 'about_pool_amenities')
                ->delete();
        }

        if (Schema::hasTable('local_amenities')) {
            DB::table('local_amenities')
                ->where('display_context', 'pool')
                ->delete();
        }
    }
};
