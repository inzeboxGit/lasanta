<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Nos soirées musicales',
                'published_at' => '2025-12-11',
                'excerpt' => 'Un moment à vivre intensément...',
                'body' => "Retrouvez nos soirées musicales dans une ambiance conviviale et chaleureuse à la Résidence Hotel La Santa.",
                'author' => 'Hotel La Santa',
            ],
            [
                'title' => "FIERA DI L'ALIVU",
                'published_at' => '2025-12-24',
                'excerpt' => "A Fiera di l'Alivu, une manifestation rurale et identitaire de renom et de qualité.",
                'body' => "Nous mettons en avant cet événement emblématique qui valorise le terroir, les producteurs et la culture locale.",
                'author' => 'Hotel La Santa',
            ],
            [
                'title' => 'Il est des instants où le temps se fait douceur',
                'published_at' => '2025-12-21',
                'excerpt' => 'Rituels de soins',
                'body' => "Découvrez nos instants bien-être et nos rituels de soins pour un moment de détente.",
                'author' => 'Hotel La Santa',
            ],
        ];

        foreach ($items as $item) {
            $slug = Str::slug($item['title']);

            News::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $item['title'],
                    'author' => $item['author'],
                    'published_at' => $item['published_at'],
                    'hero_image' => null,
                    'cover_image' => null,
                    'excerpt' => $item['excerpt'],
                    'body' => $item['body'],
                    'status' => 'published',
                ]
            );
        }
    }
}
