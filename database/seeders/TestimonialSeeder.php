<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Jeanne',
                'content' => 'Nous sommes venus une nuit à l’hôtel et nous avons eu l occasion de manger au restaurant. Le cadre est magnifique',
                'photo_path' => 'img/testimonial_1.jpg',
                'published_at' => '2025-10-12',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'name' => 'Jean Francois',
                'content' => 'Nous sommes venus une nuit à l’hôtel et nous avons eu l occasion de manger au restaurant. Le cadre est magnifique',
                'photo_path' => 'img/testimonial_1.jpg',
                'published_at' => '2025-11-02',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'name' => 'Marie',
                'content' => 'Nous sommes venus une nuit à l’hôtel et nous avons eu l occasion de manger au restaurant. Le cadre est magnifique',
                'photo_path' => 'img/testimonial_1.jpg',
                'published_at' => '2025-12-03',
                'sort_order' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($items as $item) {
            Testimonial::updateOrCreate(
                [
                    'name' => $item['name'],
                    'published_at' => $item['published_at'],
                ],
                [
                    'content' => $item['content'],
                    'photo_path' => $item['photo_path'],
                    'sort_order' => $item['sort_order'],
                    'is_published' => $item['is_published'],
                ]
            );
        }
    }
}
