<?php

return [
    'locales' => [
        'fr' => 'Français',
        'en' => 'English',
        'de' => 'Deutsch',
        'it' => 'Italiano',
    ],

    'types' => [
        'about_section' => [
            'label' => 'Section À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
        ],
        'home_hero' => [
            'label' => 'Hero accueil',
            'class' => \App\Models\HomeHeroSetting::class,
            'fields' => ['small_title', 'title', 'dates_label', 'adults_label', 'children_label', 'search_label'],
            'display_field' => 'section',
        ],
        'promo_section' => [
            'label' => 'Section Promo',
            'class' => \App\Models\PromoSectionSetting::class,
            'fields' => ['subtitle', 'title', 'text'],
            'wysiwyg_fields' => ['text'],
            'display_field' => 'title',
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
        'restaurant_page' => [
            'label' => 'Restaurant - Header',
            'class' => \App\Models\LocalAmenitySectionSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text'],
            'display_field' => 'section',
            'where' => [
                'section' => 'about_local_amenities',
            ],
        ],
        'restaurant_about' => [
            'label' => 'Restaurant - À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'restaurant_about',
            ],
        ],
        'restaurant_extra_text' => [
            'label' => 'Restaurant - Après À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'restaurant_after_about',
            ],
        ],
        'restaurant_items' => [
            'label' => 'Restaurant - Contenu',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
            'where' => [
                'display_context' => \App\Models\LocalAmenity::CONTEXT_RESTAURANT,
            ],
        ],
        'pool_page' => [
            'label' => 'Piscine - Header',
            'class' => \App\Models\LocalAmenitySectionSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text'],
            'display_field' => 'section',
            'where' => [
                'section' => 'about_pool_amenities',
            ],
        ],
        'pool_about' => [
            'label' => 'Piscine - À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'pool_about',
            ],
        ],
        'pool_extra_text' => [
            'label' => 'Piscine - Après À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'pool_after_about',
            ],
        ],
        'pool_items' => [
            'label' => 'Piscine - Contenu',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
            'where' => [
                'display_context' => \App\Models\LocalAmenity::CONTEXT_POOL,
            ],
        ],
        'page_headers' => [
            'label' => 'En-têtes de page',
            'class' => \App\Models\PageHeaderSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text', 'availability_small', 'availability_title', 'availability_text'],
            'display_field' => 'page',
        ],
        'contact_page' => [
            'label' => 'Page Contact',
            'class' => \App\Models\PageHeaderSetting::class,
            'fields' => ['subtitle', 'title', 'availability_small', 'availability_title', 'availability_text', 'info_booking_label', 'select_room_label', 'adults_label', 'children_label', 'book_now_label'],
            'display_field' => 'page',
            'where' => [
                'page' => 'contact',
            ],
        ],
        'appartment_page' => [
            'label' => 'Page Appartements',
            'class' => \App\Models\AppartmentPageSetting::class,
            'fields' => ['subtitle', 'title', 'home_subtitle', 'home_title'],
            'display_field' => 'page',
        ],
        'legal_pages' => [
            'label' => 'Conditions & Confidentialité',
            'class' => \App\Models\LegalPage::class,
            'fields' => ['header_subtitle', 'header_title', 'body'],
            'wysiwyg_fields' => ['body'],
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
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'local_amenities' => [
            'label' => 'Commodités locales',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'rooms' => [
            'label' => 'Chambres',
            'class' => \App\Models\Room::class,
            'fields' => ['title', 'subtitle', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'news' => [
            'label' => 'Actualités',
            'class' => \App\Models\News::class,
            'fields' => ['title', 'excerpt', 'body'],
            'wysiwyg_fields' => ['excerpt', 'body'],
            'display_field' => 'title',
        ],
        'testimonials' => [
            'label' => 'Témoignages',
            'class' => \App\Models\Testimonial::class,
            'fields' => ['name', 'content'],
            'wysiwyg_fields' => ['content'],
            'display_field' => 'name',
        ],
    ],
];
