<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class InstallationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Parking privé',
                'icon' => 'customicon-private-parking',
                'description' => 'Profitez de notre parking fermé, surveillé et sécurisé',
                'sort_order' => 1,
            ],
            [
                'title' => 'Wifi haut débit',
                'icon' => 'customicon-wifi',
                'description' => 'Profitez de notre wifi très haut débit',
                'sort_order' => 2,
            ],
            [
                'title' => 'Bar & Restaurant',
                'icon' => 'customicon-cocktail',
                'description' => "Retrouvez-vous autour d'un verre de vin ou d'un cocktail et partagez un moment",
                'sort_order' => 3,
            ],
            [
                'title' => 'Piscine',
                'icon' => 'customicon-swimming-pool',
                'description' => "Profitez de notre piscine ainsi qu'une salle de fitness",
                'sort_order' => 4,
            ],
        ];

        foreach ($items as $item) {
            Amenity::updateOrCreate(
                ['title' => $item['title'], 'scope' => 'home'],
                [
                    'icon' => $item['icon'],
                    'description' => $item['description'],
                    'image_path' => null,
                    'sort_order' => $item['sort_order'],
                    'is_published' => true,
                ]
            );
        }
    }
}
