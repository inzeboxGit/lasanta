<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['title' => 'King Size Bed', 'icon' => 'icon-hotel-double_bed_2'],
            ['title' => 'Safety Box', 'icon' => 'icon-hotel-safety_box'],
            ['title' => 'Balcony', 'icon' => 'icon-hotel-patio'],
            ['title' => '32 Inch TV', 'icon' => 'icon-hotel-tv'],
            ['title' => 'Disable Access', 'icon' => 'icon-hotel-disable'],
            ['title' => 'Pet Allowed', 'icon' => 'icon-hotel-dog'],
            ['title' => 'Welcome Bottle', 'icon' => 'icon-hotel-bottle'],
            ['title' => 'Wifi / Netflix access', 'icon' => 'icon-hotel-wifi'],
            ['title' => 'Air Dryer', 'icon' => 'icon-hotel-hairdryer'],
            ['title' => 'Air Condition', 'icon' => 'icon-hotel-condition'],
            ['title' => 'Loundry Service', 'icon' => 'icon-hotel-loundry'],
        ];

        foreach ($items as $item) {
            Amenity::updateOrCreate(
                ['title' => $item['title'], 'scope' => 'room'],
                [
                    'icon' => $item['icon'],
                    'description' => null,
                    'image_path' => null,
                    'sort_order' => 0,
                    'is_published' => true,
                ]
            );
        }
    }
}
