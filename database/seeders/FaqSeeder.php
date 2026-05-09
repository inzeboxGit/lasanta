<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqSectionSetting;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        FaqSectionSetting::firstOrCreate(
            ['id' => 1],
            [
                'subtitle'     => 'Questions populaires',
                'title'        => 'Foire aux questions',
                'description'  => 'Retrouvez les réponses aux questions les plus fréquemment posées par nos visiteurs.',
                'button_label' => 'Toutes les questions',
                'button_link'  => '#',
            ]
        );

        $faqs = [
            [
                'question'   => 'Quelles sont les modalités d\'annulation ?',
                'answer'     => 'Toute annulation effectuée plus de 7 jours avant la date d\'arrivée est remboursée intégralement. En deçà de ce délai, un forfait correspondant à une nuit sera retenu.',
                'sort_order' => 1,
            ],
            [
                'question'   => 'Comment puis-je contacter la résidence ?',
                'answer'     => 'Vous pouvez nous joindre par téléphone, par e-mail ou via le formulaire de contact disponible sur notre site. Notre équipe est disponible du lundi au dimanche de 9h à 19h.',
                'sort_order' => 2,
            ],
            [
                'question'   => 'Les animaux de compagnie sont-ils acceptés ?',
                'answer'     => 'Les animaux de compagnie sont acceptés sous réserve de prévenir la réception à l\'avance. Des frais de nettoyage supplémentaires peuvent s\'appliquer.',
                'sort_order' => 3,
            ],
            [
                'question'   => 'Le Wi-Fi est-il inclus ?',
                'answer'     => 'Oui, le Wi-Fi haut débit est disponible dans toutes les chambres et les espaces communs, sans supplément.',
                'sort_order' => 4,
            ],
        ];

        foreach ($faqs as $data) {
            Faq::firstOrCreate(
                ['question' => $data['question']],
                $data + ['is_published' => true]
            );
        }
    }
}
