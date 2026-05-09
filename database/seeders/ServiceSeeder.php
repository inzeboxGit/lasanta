<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'tab_key'     => 'restaurant',
                'subtitle'    => 'Addres of taste',
                'title'       => 'Restaurant',
                'description' => 'Restaurant quisue sodale intion varius estibum miss arman ortiton telus euismod nis the massa fermen.',
                'image'       => 'img/offers/05.jpg',
                'button_link' => '#',
                'button_text' => 'View menu',
                'icon'        => 'fa-solid fa-user-chef',
                'sort_order'  => 1,
                'is_published'=> true,
            ],
            [
                'tab_key'     => 'spa',
                'subtitle'    => 'So Many Ways to Unwind',
                'title'       => 'Spa & Wellness',
                'description' => 'Wellness quisque sodales intioni varius estibum miss arman ortiton telus euismod nis the massa nutodio farmention lorem pretium ametis velen fermen.',
                'image'       => 'img/offers/06.jpg',
                'button_link' => '#',
                'button_text' => 'View details',
                'icon'        => 'fa-solid fa-spa',
                'sort_order'  => 2,
                'is_published'=> true,
            ],
            [
                'tab_key'     => 'pool',
                'subtitle'    => 'Indoor & Outdoor',
                'title'       => 'Pool Swimming',
                'description' => 'Swimming quisque sodales intioni varius estibum miss arman ortiton telus euismod nis the massa nutodio farmention lorem pretium ametis velen fermen.',
                'image'       => 'img/offers/07.jpg',
                'button_link' => '#',
                'button_text' => 'View details',
                'icon'        => 'fa-solid fa-person-swimming',
                'sort_order'  => 3,
                'is_published'=> true,
            ],
            [
                'tab_key'     => 'fitness',
                'subtitle'    => 'Training Spaces',
                'title'       => 'Fitness Center',
                'description' => 'Fitness quisque sodales intioni varius estibum miss arman ortiton telus euismod nis the massa nutodio farmention lorem pretium ametis velen fermen.',
                'image'       => 'img/offers/08.jpg',
                'button_link' => '#',
                'button_text' => 'View details',
                'icon'        => 'fa-solid fa-dumbbell',
                'sort_order'  => 4,
                'is_published'=> true,
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(['tab_key' => $data['tab_key']], $data);
        }
    }
}
