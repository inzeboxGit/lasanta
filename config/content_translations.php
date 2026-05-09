<?php

return [
    'locales' => [
        'fr' => 'Français',
        'en' => 'English',
        'de' => 'Deutsch',
        'it' => 'Italiano',
    ],

    'types' => [
        // ── Accueil ──────────────────────────────────────────────────────────
        'home_hero' => [
            'label' => 'Accueil - Hero',
            'class' => \App\Models\HomeHeroSetting::class,
            'fields' => ['small_title', 'title', 'dates_label', 'check_in_label', 'check_out_label', 'adults_label', 'children_label', 'search_label'],
            'display_field' => 'section',
        ],
        'about_section' => [
            'label' => 'Accueil - À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
        ],
        'installation_section' => [
            'label' => 'Accueil - Installations',
            'class' => \App\Models\InstallationSectionSetting::class,
            'fields' => ['subtitle', 'title', 'description'],
            'display_field' => 'section',
        ],
        'promo_section' => [
            'label' => 'Accueil - Promo',
            'class' => \App\Models\PromoSectionSetting::class,
            'fields' => ['subtitle', 'title', 'text', 'button_text'],
            'wysiwyg_fields' => ['text'],
            'display_field' => 'title',
        ],
        'faq_section' => [
            'label' => 'Accueil - FAQ (section)',
            'class' => \App\Models\FaqSectionSetting::class,
            'fields' => ['subtitle', 'title', 'description', 'button_label'],
            'display_field' => 'subtitle',
        ],
        'faqs' => [
            'label' => 'Accueil - FAQ (questions)',
            'class' => \App\Models\Faq::class,
            'fields' => ['question', 'answer'],
            'wysiwyg_fields' => ['answer'],
            'display_field' => 'question',
        ],
        'services' => [
            'label' => 'Accueil - Services',
            'class' => \App\Models\Service::class,
            'fields' => ['subtitle', 'title', 'description', 'button_text'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        // ── Nos chambres ─────────────────────────────────────────────────────
        'appartment_page' => [
            'label' => 'Nos chambres - Paramètres',
            'class' => \App\Models\AppartmentPageSetting::class,
            'fields' => ['subtitle', 'title', 'home_subtitle', 'home_title'],
            'display_field' => 'page',
        ],
        'rooms' => [
            'label' => 'Nos chambres - Chambres',
            'class' => \App\Models\Room::class,
            'fields' => ['title', 'subtitle', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'amenities' => [
            'label' => 'Nos chambres - Équipements',
            'class' => \App\Models\Amenity::class,
            'fields' => ['title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        // ── Restaurant ───────────────────────────────────────────────────────
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
        // ── Piscine ──────────────────────────────────────────────────────────
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
        // ── Activités ────────────────────────────────────────────────────────
        'activites_about' => [
            'label' => 'Activités - À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'activites_about',
            ],
        ],
        'activites_gallery' => [
            'label' => 'Activités - Galerie',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title'],
            'display_field' => 'section',
            'where' => [
                'section' => 'activites_gallery',
            ],
        ],
        // ── Actualités ───────────────────────────────────────────────────────
        'news' => [
            'label' => 'Actualités',
            'class' => \App\Models\News::class,
            'fields' => ['title', 'excerpt', 'body', 'category'],
            'wysiwyg_fields' => ['excerpt', 'body'],
            'display_field' => 'title',
        ],
        // ── Contact ──────────────────────────────────────────────────────────
        'contact_page' => [
            'label' => 'Contact',
            'class' => \App\Models\PageHeaderSetting::class,
            'fields' => ['subtitle', 'title', 'availability_small', 'availability_title', 'availability_text', 'info_booking_label', 'select_room_label', 'adults_label', 'children_label', 'book_now_label', 'calendar_night_label', 'calendar_nights_label'],
            'display_field' => 'page',
            'where' => [
                'page' => 'contact',
            ],
        ],
        // ── Pages légales ────────────────────────────────────────────────────
        'legal_pages' => [
            'label' => 'Conditions & Confidentialité',
            'class' => \App\Models\LegalPage::class,
            'fields' => ['header_subtitle', 'header_title', 'body'],
            'wysiwyg_fields' => ['body'],
            'display_field' => 'page',
        ],
        // ── Général ──────────────────────────────────────────────────────────
        'page_headers' => [
            'label' => 'En-têtes de page',
            'class' => \App\Models\PageHeaderSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text', 'availability_small', 'availability_title', 'availability_text', 'calendar_night_label', 'calendar_nights_label'],
            'display_field' => 'page',
        ],
        'local_amenities' => [
            'label' => 'Commodités locales',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'testimonials' => [
            'label' => 'Témoignages',
            'class' => \App\Models\Testimonial::class,
            'fields' => ['name', 'content'],
            'wysiwyg_fields' => ['content'],
            'display_field' => 'name',
        ],
        'site_settings' => [
            'label' => 'Paramètres site',
            'class' => \App\Models\SiteSetting::class,
            'fields' => ['site_name', 'address', 'maintenance_message'],
            'display_field' => 'setting_key',
        ],
    ],
];
