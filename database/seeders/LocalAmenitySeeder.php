<?php

namespace Database\Seeders;

use App\Models\LocalAmenity;
use Illuminate\Database\Seeder;

class LocalAmenitySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Restaurant',
                'description' => "Un Restaurant panoramique Notre Chef, Marc Chataignier se fera un plaisir de vous faire découvrir dans le cadre feutré d’une terrasse bénéficiant d'une vue panoramique dominant la baie d'Ile-Rousse",
                'image_path' => 'img/local_amenities_1.jpg',
                'link_url' => 'about.html',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Plages',
                'description' => 'La plage de Saleccia est située en Corse, le long du désert des Agriates, territoire dont l’origine du nom évoque des terres agricoles fertiles.',
                'image_path' => 'img/local_amenities_3.jpg',
                'link_url' => 'about.html',
                'sort_order' => 2,
                'is_published' => true,
            ],
        ];

        foreach ($items as $item) {
            LocalAmenity::updateOrCreate(
                ['title' => $item['title']],
                [
                    'description' => $item['description'],
                    'image_path' => $item['image_path'],
                    'link_url' => $item['link_url'],
                    'sort_order' => $item['sort_order'],
                    'is_published' => $item['is_published'],
                ]
            );
        }
    }
}
