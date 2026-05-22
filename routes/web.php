<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/media/{path}', function (string $path) {
    abort_unless(Storage::disk('public')->exists($path), 404);

    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('media.public');

Route::get('/', function () {
    $heroSetting = (object) [
        'show_booking_form' => true,
        'small_title' => 'Expérience hôtelière',
        'title' => 'Une expérience unique où séjourner',
        'button_link' => '/appartements',
        'button_target' => '_self',
        'background_type' => 'video',
        'background_video' => 'video/sunset.mp4',
        'youtube_video_url' => null,
        'background_image' => 'img/hero_home_1.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('home_hero_settings')) {
        $heroSetting = \App\Models\HomeHeroSetting::firstOrCreate(
            ['section' => 'home_hero'],
            [
                'show_booking_form' => true,
                'small_title' => 'Expérience hôtelière',
                'title' => 'Une expérience unique où séjourner',
                'button_link' => '/appartements',
                'button_target' => '_self',
                'background_type' => 'video',
                'background_video' => 'video/sunset.mp4',
                'youtube_video_url' => null,
                'background_image' => 'img/hero_home_1.jpg',
            ]
        );
        $heroSetting->loadMissing('translations');
    }

    $installations = \App\Models\Amenity::whereIn('scope', ['home', 'both'])
        ->with('translations')
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    $homeNews = \App\Models\News::where('status', 'published')
        ->with('translations')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->limit(3)
        ->get();

    $localComodites = \App\Models\LocalAmenity::forDisplayContext(\App\Models\LocalAmenity::CONTEXT_HOME)
        ->where('is_published', true)
        ->with('translations')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    $homeTestimonials = \App\Models\Testimonial::where('is_published', true)
        ->with('translations')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    $homeVideoSetting = (object) [
        'header_image' => 'img/video-background.png',
        'subtitle' => 'Expérience hôtelière',
        'title' => 'Profiter d un moment de détente',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('page_header_settings')) {
        $homeVideoSetting = \App\Models\PageHeaderSetting::firstOrCreate(
            ['page' => 'home_video'],
            [
                'header_image' => 'img/video-background.png',
                'subtitle' => 'Expérience hôtelière',
                'title' => 'Profiter d un moment de détente',
                'hero_text' => '',
            ]
        );
        $homeVideoSetting->loadMissing('translations');
    }

    $testimonialSectionSetting = (object) [
        'header_image' => 'img/hero_home_1.jpg',
        'subtitle' => 'TÉMOIGNAGES',
        'title' => 'Ce que les clients disent',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('page_header_settings')) {
        $testimonialSectionSetting = \App\Models\PageHeaderSetting::firstOrCreate(
            ['page' => 'testimonials'],
            [
                'header_image' => 'img/hero_home_1.jpg',
                'subtitle' => 'TÉMOIGNAGES',
                'title' => 'Ce que les clients disent',
                'hero_text' => '',
            ]
        );
        $testimonialSectionSetting->loadMissing('translations');
    }

    $homeRooms = \App\Models\Room::with(['translations', 'amenities'])
        ->where('status', 'published')
        ->when(
            \Illuminate\Support\Facades\Schema::hasColumn('rooms', 'sort_order'),
            fn ($query) => $query->orderBy('sort_order')->orderBy('id'),
            fn ($query) => $query->latest()
        )
        ->limit(3)
        ->get();

    $appartmentPageSetting = (object) [
        'home_title' => null,
        'home_subtitle' => null,
        'home_description' => null,
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('appartment_page_settings')) {
        $defaults = [];

        if (\Illuminate\Support\Facades\Schema::hasColumns('appartment_page_settings', ['home_title', 'home_subtitle'])) {
            $defaults['home_title'] = 'Chambres et suites';
            $defaults['home_subtitle'] = 'Expérience hôtelière';
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('appartment_page_settings', 'home_description')) {
            $defaults['home_description'] = null;
        }

        $appartmentPageSetting = \App\Models\AppartmentPageSetting::firstOrCreate(
            ['page' => 'appartements'],
            $defaults
        );
    }

    $aboutSectionSetting = (object) [
        'small_title' => 'À PROPOS DE NOUS',
        'title' => 'La Résidence Hotel La Santa',
        'lead' => 'Une conception du tourisme...',
        'description' => "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
        'signature' => 'L’équipe du Hotel La Santa',
        'button_text' => 'Découvrir Le Domaine',
        'button_link' => '',
        'button_target' => '_self',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $aboutSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'home_about'],
            [
                'small_title' => 'À PROPOS DE NOUS',
                'title' => 'La Résidence Hotel La Santa',
                'lead' => 'Une conception du tourisme...',
                'description' => "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
                'signature' => 'L’équipe du Hotel La Santa',
                'button_text' => 'Découvrir Le Domaine',
                'button_link' => '',
                'button_target' => '_self',
                'main_image' => 'img/home_2.jpg',
                'overlay_image' => 'img/home_1.jpg',
            ]
        );
        $aboutSectionSetting->loadMissing('translations');
    }

    $installationSectionSetting = (object) [
        'subtitle' => 'RÉsidence Hotel La Santa',
        'title' => 'Installations principales',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('installation_section_settings')) {
        $installationSectionSetting = \App\Models\InstallationSectionSetting::firstOrCreate(
            ['section' => 'home_installations'],
            [
                'subtitle' => 'RÉsidence Hotel La Santa',
                'title' => 'Installations principales',
            ]
        );
        $installationSectionSetting->loadMissing('translations');
    }

    $promoSetting = (object) [
        'is_enabled' => false,
        'start_date' => null,
        'end_date' => null,
        'subtitle' => '',
        'title' => '',
        'text' => '',
        'button_link' => '',
        'button_text' => '',
        'image' => '',
    ];

    $promoHeaderSetting = (object) ['subtitle' => 'NOS OFFRES', 'title' => 'OFFRES SPÉCIALES', 'header_image' => ''];
    if (\Illuminate\Support\Facades\Schema::hasTable('page_header_settings')) {
        $promoHeaderSetting = \App\Models\PageHeaderSetting::firstOrCreate(
            ['page' => 'home_promo_section'],
            ['subtitle' => 'NOS OFFRES', 'title' => 'OFFRES SPÉCIALES', 'header_image' => '', 'hero_text' => '']
        );
    }

    $homePromos = collect();

    if (\Illuminate\Support\Facades\Schema::hasTable('promo_section_settings')) {
        $promoSetting = \App\Models\PromoSectionSetting::query()
            ->where('section', 'home_promo')
            ->where('is_enabled', true)
            ->latest('updated_at')
            ->latest('id')
            ->first() ?? $promoSetting;

        if ($promoSetting instanceof \App\Models\PromoSectionSetting) {
            $promoSetting->loadMissing('translations');
        }

        $homePromos = \App\Models\PromoSectionSetting::query()
            ->where('section', 'home_promo')
            ->where('is_enabled', true)
            ->latest('id')
            ->get()
            ->each(fn ($p) => $p->loadMissing('translations'));
    }

    $homeServices = collect();
    if (\Illuminate\Support\Facades\Schema::hasTable('services')) {
        $homeServices = \App\Models\Service::where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    $bookingFooterSetting = (object) [
        'header_image' => 'img/rooms/01.jpg',
        'subtitle'     => 'Hotel Experience',
        'title'        => 'Booking Form',
    ];
    if (\Illuminate\Support\Facades\Schema::hasTable('page_header_settings')) {
        $bookingFooterSetting = \App\Models\PageHeaderSetting::firstOrCreate(
            ['page' => 'booking_footer'],
            [
                'header_image' => 'img/rooms/01.jpg',
                'subtitle'     => 'Hotel Experience',
                'title'        => 'Booking Form',
                'hero_text'    => '',
            ]
        );
    }

    $localAmenitySectionSetting = (object) ['subtitle' => 'Nos activités', 'title' => 'Activités & Loisirs'];
    if (\Illuminate\Support\Facades\Schema::hasTable('local_amenity_section_settings')) {
        $localAmenitySectionSetting = \App\Models\LocalAmenitySectionSetting::firstOrCreate(
            ['section' => 'home_activities'],
            ['subtitle' => 'Nos activités', 'title' => 'Activités & Loisirs', 'header_image' => '', 'hero_text' => '']
        );
        $localAmenitySectionSetting->loadMissing('translations');
    }

    $newsSectionSetting = (object) ['subtitle' => 'Dernières nouvelles', 'title' => 'Actualités'];
    if (\Illuminate\Support\Facades\Schema::hasTable('page_header_settings')) {
        $newsSectionSetting = \App\Models\PageHeaderSetting::firstOrCreate(
            ['page' => 'home_news_section'],
            ['subtitle' => 'Dernières nouvelles', 'title' => 'Actualités', 'header_image' => '', 'hero_text' => '']
        );
    }

    $homeFaqs = collect();
    $faqSectionSetting = null;
    if (\Illuminate\Support\Facades\Schema::hasTable('faqs')) {
        $homeFaqs = \App\Models\Faq::where('is_published', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }
    if (\Illuminate\Support\Facades\Schema::hasTable('faq_section_settings')) {
        $faqSectionSetting = \App\Models\FaqSectionSetting::firstOrCreate(
            ['id' => 1],
            [
                'subtitle'     => 'Questions populaires',
                'title'        => 'Foire aux questions',
                'description'  => '',
                'button_label' => 'Toutes les questions',
                'button_link'  => '#',
            ]
        );
        $faqSectionSetting->loadMissing('translations');
    }

    return themed_view('home', compact('heroSetting', 'installations', 'homeNews', 'localComodites', 'homeTestimonials', 'homeVideoSetting', 'testimonialSectionSetting', 'installationSectionSetting', 'aboutSectionSetting', 'promoSetting', 'homeRooms', 'appartmentPageSetting', 'homePromos', 'homeServices', 'bookingFooterSetting', 'localAmenitySectionSetting', 'promoHeaderSetting', 'newsSectionSetting', 'homeFaqs', 'faqSectionSetting'));
});

Route::get('/contacts', function () {
    $rooms = \App\Models\Room::with('translations')
        ->where('status', 'published')
        ->when(
            \Illuminate\Support\Facades\Schema::hasColumn('rooms', 'sort_order'),
            fn ($query) => $query->orderBy('sort_order')->orderBy('id'),
            fn ($query) => $query->latest()
        )
        ->get();

    $contactPageSetting = (object) [
        'header_image' => 'img/hero_home_2.jpg',
        'subtitle' => 'Expérience hôtelière',
        'title' => 'Contact',
        'availability_small' => ' Hotel La Santa',
        'availability_title' => 'Disponibilité',
        'availability_text' => 'Consultez les disponibilités et contactez-nous pour finaliser votre réservation.',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('page_header_settings')) {
        $contactPageSetting = \App\Models\PageHeaderSetting::firstOrCreate(
            ['page' => 'contact'],
            [
                'header_image' => 'img/hero_home_2.jpg',
                'subtitle' => 'Expérience hôtelière',
                'title' => 'Contact',
                'availability_small' => ' Hotel La Santa',
                'availability_title' => 'Disponibilité',
                'availability_text' => 'Consultez les disponibilités et contactez-nous pour finaliser votre réservation.',
            ]
        );
        $contactPageSetting->loadMissing('translations');
    }

    $homeFaqs = collect();
    $faqSectionSetting = null;
    if (\Illuminate\Support\Facades\Schema::hasTable('faqs')) {
        $homeFaqs = \App\Models\Faq::where('is_published', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }
    if (\Illuminate\Support\Facades\Schema::hasTable('faq_section_settings')) {
        $faqSectionSetting = \App\Models\FaqSectionSetting::find(1);
        $faqSectionSetting?->loadMissing('translations');
    }

    return themed_view('contact', compact('contactPageSetting', 'rooms', 'homeFaqs', 'faqSectionSetting'));
});
Route::post('/contacts', [\App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

Route::get('/termsOfUse', function () {
    $locale = app()->getLocale();
    if (!in_array($locale, ['fr', 'en', 'de', 'it'], true)) {
        $locale = 'en';
    }

    $termsHtml = \App\Models\LegalPage::defaultBody(\App\Models\LegalPage::PAGE_TERMS, $locale);
    $termsPage = null;

    if (\Illuminate\Support\Facades\Schema::hasTable('legal_pages')) {
        $termsPage = \App\Models\LegalPage::firstOrCreate(
            ['page' => \App\Models\LegalPage::PAGE_TERMS],
            [
                'header_title' => 'Conditions d’utilisations',
                'header_subtitle' => 'Informations légales',
                'header_background_color' => '#000000',
                'body' => \App\Models\LegalPage::defaultBody(\App\Models\LegalPage::PAGE_TERMS),
            ]
        );
        $termsPage->loadMissing('translations');
        $termsHtml = $termsPage->t('body', $locale) ?: $termsHtml;
    }

    return themed_view('terms-of-use', compact('termsHtml', 'termsPage'));
})->name('termsOfUse.index');

Route::get('/privacy', function () {
    $locale = app()->getLocale();
    if (!in_array($locale, ['fr', 'en', 'de', 'it'], true)) {
        $locale = 'en';
    }

    $privacyHtml = \App\Models\LegalPage::defaultBody(\App\Models\LegalPage::PAGE_PRIVACY, $locale);
    $privacyPage = null;

    if (\Illuminate\Support\Facades\Schema::hasTable('legal_pages')) {
        $privacyPage = \App\Models\LegalPage::firstOrCreate(
            ['page' => \App\Models\LegalPage::PAGE_PRIVACY],
            [
                'header_title' => 'Mentions légales',
                'header_subtitle' => 'Informations légales',
                'header_background_color' => '#000000',
                'body' => \App\Models\LegalPage::defaultBody(\App\Models\LegalPage::PAGE_PRIVACY),
            ]
        );
        $privacyPage->loadMissing('translations');
        $privacyHtml = $privacyPage->t('body', $locale) ?: $privacyHtml;
    }

    return themed_view('privacy', compact('privacyHtml', 'privacyPage'));
})->name('privacy.index');

Route::get('/conditions', function () {
    return redirect()->route('termsOfUse.index');
})->name('conditions.index');

Route::get('/restaurant', function () {
    $localComodites = collect();
    if (\Illuminate\Support\Facades\Schema::hasTable('local_amenities')) {
        $localComodites = \App\Models\LocalAmenity::forDisplayContext(\App\Models\LocalAmenity::CONTEXT_RESTAURANT)
            ->where('is_published', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    $localAmenitySectionSetting = (object) [
        'header_image' => 'img/home_2.jpg',
        'subtitle' => '',
        'title' => '',
        'hero_text' => '',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('local_amenity_section_settings')) {
        $localAmenitySectionSetting = \App\Models\LocalAmenitySectionSetting::firstOrCreate(
            ['section' => 'about_local_amenities'],
            [
                'header_image' => 'img/home_2.jpg',
                'subtitle' => '',
                'title' => '',
                'hero_text' => '',
            ]
        );
        $localAmenitySectionSetting->loadMissing('translations');
    }

    $aboutSectionSetting = (object) [
        'small_title' => '',
        'title' => '',
        'lead' => '',
        'description' => '',
        'signature' => '',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $aboutSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'restaurant_about'],
            [
                'small_title' => '',
                'title' => '',
                'lead' => '',
                'description' => '',
                'signature' => '',
                'main_image' => 'img/home_2.jpg',
                'overlay_image' => 'img/home_1.jpg',
            ]
        );
        $aboutSectionSetting->loadMissing('translations');
    }
    $extraTextSectionSetting = null;

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $extraTextSectionSetting = \App\Models\AboutSectionSetting::where('section', 'restaurant_after_about')->first();
        if ($extraTextSectionSetting) {
            $extraTextSectionSetting->loadMissing('translations');
        }
    }

    $restaurantInfoSectionSetting = (object) [
        'small_title' => 'Hours',
        'title' => 'Dress Code',
        'lead' => "Breakfast: 7.00 am - 11.00 am (daily)\nLunch: 12.00 noon - 2.00 pm (daily)\nDinner: open from 6.30 pm, last order at 10.00 pm (daily)",
        'description' => 'Smart casual (no shorts, hats, or sandals permitted).',
        'signature' => 'Terrace',
        'main_image' => 'Open for drinks only.',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $restaurantInfoSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'restaurant_info_block'],
            [
                'small_title' => 'Hours',
                'title' => 'Dress Code',
                'lead' => "Breakfast: 7.00 am - 11.00 am (daily)\nLunch: 12.00 noon - 2.00 pm (daily)\nDinner: open from 6.30 pm, last order at 10.00 pm (daily)",
                'description' => 'Smart casual (no shorts, hats, or sandals permitted).',
                'signature' => 'Terrace',
                'main_image' => 'Open for drinks only.',
                'overlay_image' => '',
                'third_image' => '',
            ]
        );
        $restaurantInfoSectionSetting->loadMissing('translations');
    }

    $restaurantGallerySetting = (object) ['small_title' => 'Image Gallery', 'title' => 'Restaurant Gallery', 'gallery' => []];
    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings') &&
        \Illuminate\Support\Facades\Schema::hasColumn('about_section_settings', 'gallery')) {
        $restaurantGallerySetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'restaurant_gallery'],
            ['small_title' => 'Image Gallery', 'title' => 'Restaurant Gallery', 'gallery' => []]
        );
    }

    return themed_view('restaurant', compact('aboutSectionSetting', 'localComodites', 'localAmenitySectionSetting', 'extraTextSectionSetting', 'restaurantInfoSectionSetting', 'restaurantGallerySetting'));
})->name('restaurant.index');

Route::get('/piscine', function () {
    $localComodites = collect();
    if (\Illuminate\Support\Facades\Schema::hasTable('local_amenities')) {
        $localComodites = \App\Models\LocalAmenity::forDisplayContext(\App\Models\LocalAmenity::CONTEXT_POOL)
            ->where('is_published', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    $localAmenitySectionSetting = (object) [
        'header_image' => 'img/home_2.jpg',
        'subtitle' => 'RÉsidence Hotel La Santa',
        'title' => 'Piscine',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('local_amenity_section_settings')) {
        $localAmenitySectionSetting = \App\Models\LocalAmenitySectionSetting::firstOrCreate(
            ['section' => 'about_pool_amenities'],
            [
                'header_image' => 'img/home_2.jpg',
                'subtitle' => 'RÉsidence Hotel La Santa',
                'title' => 'Piscine',
            ]
        );
        $localAmenitySectionSetting->loadMissing('translations');
    }

    $aboutSectionSetting = (object) [
        'small_title' => 'À PROPOS DE LA PISCINE',
        'title' => 'La Piscine Hotel La Santa',
        'lead' => 'Un espace de détente ouvert sur la résidence.',
        'description' => "Personnalisez ici le texte de présentation de la piscine, son ambiance et ses avantages pour les visiteurs.",
        'signature' => 'L’équipe de la Piscine',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $aboutSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'pool_about'],
            [
                'small_title' => 'À PROPOS DE LA PISCINE',
                'title' => 'La Piscine Hotel La Santa',
                'lead' => 'Un espace de détente ouvert sur la résidence.',
                'description' => "Personnalisez ici le texte de présentation de la piscine, son ambiance et ses avantages pour les visiteurs.",
                'signature' => 'L’équipe de la Piscine',
                'main_image' => 'img/home_2.jpg',
                'overlay_image' => 'img/home_1.jpg',
            ]
        );
        $aboutSectionSetting->loadMissing('translations');
    }

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $restaurantExtraTextSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'pool_after_about'],
            [
                'small_title' => '',
                'title' => '',
                'lead' => '',
                'description' => '',
                'signature' => '',
                'main_image' => '',
                'overlay_image' => '',
            ]
        );
        $restaurantExtraTextSectionSetting->loadMissing('translations');
    }

    $secondaryExtraSectionSetting = (object) [
        'title' => '',
        'description' => '',
        'main_image' => '',
        'overlay_image' => '',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $secondaryExtraSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'pool_bottom_section'],
            [
                'small_title' => '',
                'title' => '',
                'lead' => '',
                'description' => '',
                'signature' => '',
                'main_image' => '',
                'overlay_image' => '',
                'third_image' => '',
            ]
        );
        $secondaryExtraSectionSetting->loadMissing('translations');
    }

    $poolInfoSectionSetting = (object) [
        'small_title' => 'Horaires',
        'title'       => 'Règles',
        'lead'        => "Ouverture : 8h00 – 20h00 (tous les jours)\nFermeture hivernale : octobre – avril",
        'description' => "Respectez les règles d'hygiène et de sécurité affichées au bord de la piscine.",
        'signature'   => 'Services inclus',
        'main_image'  => 'Accès piscine inclus dans le séjour. Transats et parasols disponibles.',
    ];
    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $poolInfoSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'pool_info_block'],
            [
                'small_title' => 'Horaires',
                'title'       => 'Règles',
                'lead'        => "Ouverture : 8h00 – 20h00 (tous les jours)\nFermeture hivernale : octobre – avril",
                'description' => "Respectez les règles d'hygiène et de sécurité affichées au bord de la piscine.",
                'signature'   => 'Services inclus',
                'main_image'  => 'Accès piscine inclus dans le séjour. Transats et parasols disponibles.',
            ]
        );
        $poolInfoSectionSetting->loadMissing('translations');
    }

    $poolGallerySetting = (object) ['small_title' => 'Galerie Photos', 'title' => 'Piscine Gallery', 'gallery' => []];
    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings') &&
        \Illuminate\Support\Facades\Schema::hasColumn('about_section_settings', 'gallery')) {
        $poolGallerySetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'pool_gallery'],
            ['small_title' => 'Galerie Photos', 'title' => 'Piscine Gallery', 'gallery' => []]
        );
    }

    return themed_view('pool', compact('aboutSectionSetting', 'localComodites', 'localAmenitySectionSetting', 'restaurantExtraTextSectionSetting', 'secondaryExtraSectionSetting', 'poolInfoSectionSetting', 'poolGallerySetting'));
})->name('pool.index');

Route::get('/activites', function () {
    $installations = \App\Models\Amenity::whereIn('scope', ['home', 'both'])
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderBy('title')
        ->get();

    $activitesAboutSetting = (object) [
        'small_title' => 'Détente & Loisirs',
        'title' => 'À propos de nos activités',
        'description' => '',
        'main_image' => '',
        'overlay_image' => '',
        'third_image' => '',
    ];
    $activitesGallerySetting = (object) ['small_title' => 'Espace Loisirs', 'title' => 'Galerie des Activités'];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $activitesAboutSetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'activites_about'],
            ['small_title' => 'Détente & Loisirs', 'title' => 'À propos de nos activités']
        );
        $activitesGallerySetting = \App\Models\AboutSectionSetting::firstOrCreate(
            ['section' => 'activites_gallery'],
            ['small_title' => 'Espace Loisirs', 'title' => 'Galerie des Activités']
        );
    }

    return themed_view('activites', compact('installations', 'activitesAboutSetting', 'activitesGallerySetting'));
})->name('activites.index');

Route::get('/appartements', function () {
    $rooms = \App\Models\Room::with('amenities.translations', 'translations')
        ->where('status', 'published')
        ->when(
            \Illuminate\Support\Facades\Schema::hasColumn('rooms', 'sort_order'),
            fn ($query) => $query->orderBy('sort_order')->orderBy('id'),
            fn ($query) => $query->latest()
        )
        ->get();

    $installations = \App\Models\Amenity::whereIn('scope', ['home', 'both'])
        ->with('translations')
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    $installationSectionSetting = (object) [
        'subtitle' => 'RÉsidence Hotel La Santa',
        'title' => 'Installations principales',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('installation_section_settings')) {
        $installationSectionSetting = \App\Models\InstallationSectionSetting::firstOrCreate(
            ['section' => 'home_installations'],
            [
                'subtitle' => 'RÉsidence Hotel La Santa',
                'title' => 'Installations principales',
            ]
        );
        $installationSectionSetting->loadMissing('translations');
    }

    $appartmentPageSetting = (object) [
        'title' => 'Our Rooms & Suites',
        'subtitle' => 'Luxury Hotel Experience',
        'header_image' => 'img/rooms/4.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('appartment_page_settings')) {
        $appartmentPageSetting = \App\Models\AppartmentPageSetting::firstOrCreate(
            ['page' => 'appartements'],
            [
                'title' => 'Our Rooms & Suites',
                'subtitle' => 'Luxury Hotel Experience',
                'header_image' => 'img/rooms/4.jpg',
            ]
        );
        $appartmentPageSetting->loadMissing('translations');
    }

    $homeFaqs = collect();
    $faqSectionSetting = null;
    if (\Illuminate\Support\Facades\Schema::hasTable('faqs')) {
        $homeFaqs = \App\Models\Faq::where('is_published', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }
    if (\Illuminate\Support\Facades\Schema::hasTable('faq_section_settings')) {
        $faqSectionSetting = \App\Models\FaqSectionSetting::find(1);
        $faqSectionSetting?->loadMissing('translations');
    }

    $bookingFooterSetting = (object) [
        'header_image' => 'img/rooms/01.jpg',
        'subtitle'     => 'Hotel Experience',
        'title'        => 'Booking Form',
    ];
    if (\Illuminate\Support\Facades\Schema::hasTable('page_header_settings')) {
        $bookingFooterSetting = \App\Models\PageHeaderSetting::firstOrCreate(
            ['page' => 'booking_footer'],
            [
                'header_image' => 'img/rooms/01.jpg',
                'subtitle'     => 'Hotel Experience',
                'title'        => 'Booking Form',
                'hero_text'    => '',
            ]
        );
    }

    return themed_view('rooms', compact('rooms', 'appartmentPageSetting', 'installations', 'installationSectionSetting', 'homeFaqs', 'faqSectionSetting', 'bookingFooterSetting'));
})->name('appartements.index');

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');

Route::prefix('admin')->group(function () {
    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.attempt');

    Route::middleware(['auth', 'admin.session'])->group(function () {
        Route::get('/', function () {
            $roomsCount = \App\Models\Room::count();
            $amenitiesCount = \App\Models\Amenity::whereIn('scope', ['room', 'both'])->count();
            $newsCount = \App\Models\News::count();
            $latestRooms = \App\Models\Room::latest()->take(3)->get();

            return view('admin.dashboard', compact('roomsCount', 'amenitiesCount', 'newsCount', 'latestRooms'));
        })->name('admin.dashboard');
        Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
        Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class)->names('admin.rooms');
        Route::post('rooms/{room}/gallery/delete', [\App\Http\Controllers\Admin\RoomController::class, 'deleteGalleryImage'])->name('admin.rooms.gallery.delete');
        Route::post('rooms/page-settings', [\App\Http\Controllers\Admin\RoomController::class, 'updatePageSettings'])->name('admin.rooms.page-settings.update');
        Route::resource('amenities', \App\Http\Controllers\Admin\AmenityController::class)->names('admin.amenities');
        Route::post('amenities/activites-about', [\App\Http\Controllers\Admin\AmenityController::class, 'updateActivitesAbout'])->name('admin.amenities.activites-about.update');
        Route::post('amenities/activites-gallery', [\App\Http\Controllers\Admin\AmenityController::class, 'updateActivitesGallery'])->name('admin.amenities.activites-gallery.update');
        Route::resource('installations', \App\Http\Controllers\Admin\InstallationController::class)->names('admin.installations');
        Route::post('installations/section-settings', [\App\Http\Controllers\Admin\InstallationController::class, 'updateSectionSettings'])->name('admin.installations.section-settings.update');
        Route::resource('pool', \App\Http\Controllers\Admin\PoolAmenityController::class)->names('admin.pool');
        Route::post('pool/section-settings', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'updateSectionSettings'])->name('admin.pool.section-settings.update');
        Route::post('pool/about-section-settings', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'updateAboutSectionSettings'])->name('admin.pool.about-section-settings.update');
        Route::post('pool/extra-text-section-settings', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'updateExtraTextSectionSettings'])->name('admin.pool.extra-text-section-settings.update');
        Route::post('pool/secondary-extra-section-settings', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'updateSecondaryExtraSectionSettings'])->name('admin.pool.secondary-extra-section-settings.update');
        Route::post('pool/info-section-settings', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'updatePoolInfoSectionSettings'])->name('admin.pool.info-section.update');
        Route::post('pool/gallery-section-settings', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'updateGallerySectionSettings'])->name('admin.pool.gallery-section.update');
        Route::post('pool/gallery-section-settings/remove-image', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'removeGalleryImage'])->name('admin.pool.gallery-image.remove');
        Route::get('contact', [\App\Http\Controllers\Admin\ContactPageController::class, 'index'])->name('admin.contact.index');
        Route::post('contact', [\App\Http\Controllers\Admin\ContactPageController::class, 'update'])->name('admin.contact.update');
        Route::get('maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('admin.maintenance.index');
        Route::post('maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'update'])->name('admin.maintenance.update');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->except(['show', 'destroy'])
            ->names('admin.users');
        Route::get('about', [\App\Http\Controllers\Admin\AboutController::class, 'index'])->name('admin.about.index');
        Route::post('about', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');
        Route::get('hero', [\App\Http\Controllers\Admin\HomeHeroController::class, 'index'])->name('admin.hero.index');
        Route::post('hero', [\App\Http\Controllers\Admin\HomeHeroController::class, 'update'])->name('admin.hero.update');
        Route::post('hero/video-section', [\App\Http\Controllers\Admin\HomeHeroController::class, 'updateVideoSection'])->name('admin.hero.video-section.update');
        Route::post('hero/booking-footer', [\App\Http\Controllers\Admin\HomeHeroController::class, 'updateBookingFooter'])->name('admin.hero.booking-footer.update');
        Route::get('services', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('admin.services.index');
        Route::post('services', [\App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('admin.services.store');
        Route::put('services/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('services/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('admin.services.destroy');
        Route::get('promo', [\App\Http\Controllers\Admin\PromoController::class, 'index'])->name('admin.promo.index');
        Route::post('promo', [\App\Http\Controllers\Admin\PromoController::class, 'store'])->name('admin.promo.store');
        Route::post('promo/section', [\App\Http\Controllers\Admin\PromoController::class, 'updateSection'])->name('admin.promo.section.update');
        Route::put('promo/{promo}', [\App\Http\Controllers\Admin\PromoController::class, 'update'])->name('admin.promo.update');
        Route::delete('promo/{promo}', [\App\Http\Controllers\Admin\PromoController::class, 'destroy'])->name('admin.promo.destroy');
        Route::resource('comodites', \App\Http\Controllers\Admin\LocalAmenityController::class)->names('admin.comodites');
        Route::post('comodites/section-settings', [\App\Http\Controllers\Admin\LocalAmenityController::class, 'updateSectionSettings'])->name('admin.comodites.section-settings.update');
        Route::resource('restaurant', \App\Http\Controllers\Admin\RestaurantAmenityController::class)->names('admin.restaurant');
        Route::post('restaurant/section-settings', [\App\Http\Controllers\Admin\RestaurantAmenityController::class, 'updateSectionSettings'])->name('admin.restaurant.section-settings.update');
        Route::post('restaurant/about-section-settings', [\App\Http\Controllers\Admin\RestaurantAmenityController::class, 'updateAboutSectionSettings'])->name('admin.restaurant.about-section-settings.update');
        Route::post('restaurant/extra-text-section-settings', [\App\Http\Controllers\Admin\RestaurantAmenityController::class, 'updateExtraTextSectionSettings'])->name('admin.restaurant.extra-text-section-settings.update');
        Route::post('restaurant/info-section-settings', [\App\Http\Controllers\Admin\RestaurantAmenityController::class, 'updateRestaurantInfoSectionSettings'])->name('admin.restaurant.info-section.update');
        Route::post('restaurant/gallery-section-settings', [\App\Http\Controllers\Admin\RestaurantAmenityController::class, 'updateGallerySectionSettings'])->name('admin.restaurant.gallery-section.update');
        Route::post('restaurant/gallery-section-settings/remove-image', [\App\Http\Controllers\Admin\RestaurantAmenityController::class, 'removeGalleryImage'])->name('admin.restaurant.gallery-image.remove');
        Route::post('restaurant/gallery-section-settings/reorder', [\App\Http\Controllers\Admin\RestaurantAmenityController::class, 'reorderGallery'])->name('admin.restaurant.gallery-reorder');
        Route::post('pool/gallery-section-settings/reorder', [\App\Http\Controllers\Admin\PoolAmenityController::class, 'reorderGallery'])->name('admin.pool.gallery-reorder');
        Route::get('settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('admin.settings.update');
        Route::get('legal', [\App\Http\Controllers\Admin\LegalPageController::class, 'index'])->name('admin.legal.index');
        Route::post('legal', [\App\Http\Controllers\Admin\LegalPageController::class, 'update'])->name('admin.legal.update');
        Route::get('translations', [\App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('admin.translations.index');
        Route::post('translations', [\App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('admin.translations.update');
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->names('admin.testimonials');
        Route::post('testimonials/section-settings', [\App\Http\Controllers\Admin\TestimonialController::class, 'updateSectionSettings'])->name('admin.testimonials.section-settings.update');
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->names('admin.news');
        Route::post('news/{news}/remove-image', [\App\Http\Controllers\Admin\NewsController::class, 'removeImage'])->name('admin.news.remove-image');
        Route::post('news/page-settings', [\App\Http\Controllers\Admin\NewsController::class, 'updatePageSettings'])->name('admin.news.page-settings.update');
        Route::post('news/home-section', [\App\Http\Controllers\Admin\NewsController::class, 'updateHomeSectionSettings'])->name('admin.news.home-section.update');
        Route::get('faqs', [\App\Http\Controllers\Admin\FaqController::class, 'index'])->name('admin.faqs.index');
        Route::post('faqs', [\App\Http\Controllers\Admin\FaqController::class, 'store'])->name('admin.faqs.store');
        Route::put('faqs/{faq}', [\App\Http\Controllers\Admin\FaqController::class, 'update'])->name('admin.faqs.update');
        Route::delete('faqs/{faq}', [\App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('admin.faqs.destroy');
        Route::post('faqs/section-settings', [\App\Http\Controllers\Admin\FaqController::class, 'updateSectionSettings'])->name('admin.faqs.section-settings.update');
    });
});

Route::get('/rooms/{room:slug}', [\App\Http\Controllers\RoomController::class, 'show'])->name('rooms.show');
Route::get('/news/{news:slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
