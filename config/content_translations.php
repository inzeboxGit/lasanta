<?php

return [
    'locales' => [
        'fr' => 'Français',
        'en' => 'English',
        'de' => 'Deutsch',
        'nl' => 'Nederlands',
    ],

    'types' => [
        'about_section' => [
            'label' => 'Section À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'display_field' => 'section',
        ],
        'home_hero' => [
            'label' => 'Hero accueil',
            'class' => \App\Models\HomeHeroSetting::class,
            'fields' => ['small_title', 'title'],
            'display_field' => 'section',
        ],
        'promo_section' => [
            'label' => 'Section Promo',
            'class' => \App\Models\PromoSectionSetting::class,
            'fields' => ['subtitle', 'title', 'text'],
            'display_field' => 'section',
        ],
        'installation_section' => [
            'label' => 'Section Installations',
            'class' => \App\Models\InstallationSectionSetting::class,
            'fields' => ['subtitle', 'title'],
            'display_field' => 'section',
        ],
        'local_amenity_section' => [
            'label' => 'Section Commodités',
            'class' => \App\Models\LocalAmenitySectionSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text'],
            'display_field' => 'section',
        ],
        'page_headers' => [
            'label' => 'En-têtes de page',
            'class' => \App\Models\PageHeaderSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text'],
            'display_field' => 'page',
        ],
        'appartment_page' => [
            'label' => 'Page Appartements',
            'class' => \App\Models\AppartmentPageSetting::class,
            'fields' => ['subtitle', 'title'],
            'display_field' => 'page',
        ],
        'site_settings' => [
            'label' => 'Paramètres site',
            'class' => \App\Models\SiteSetting::class,
            'fields' => ['site_name', 'address', 'maintenance_message'],
            'display_field' => 'setting_key',
        ],
        'amenities' => [
            'label' => 'Installations / Équipements',
            'class' => \App\Models\Amenity::class,
            'fields' => ['title', 'description'],
            'display_field' => 'title',
        ],
        'local_amenities' => [
            'label' => 'Commodités locales',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['title', 'description'],
            'display_field' => 'title',
        ],
        'rooms' => [
            'label' => 'Chambres',
            'class' => \App\Models\Room::class,
            'fields' => ['title', 'subtitle', 'description'],
            'display_field' => 'title',
        ],
        'news' => [
            'label' => 'Actualités',
            'class' => \App\Models\News::class,
            'fields' => ['title', 'excerpt', 'body'],
            'display_field' => 'title',
        ],
        'testimonials' => [
            'label' => 'Témoignages',
            'class' => \App\Models\Testimonial::class,
            'fields' => ['name', 'content'],
            'display_field' => 'name',
        ],
    ],
];
