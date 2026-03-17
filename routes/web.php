<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/media/{path}', function (string $path) {
    abort_unless(Storage::disk('public')->exists($path), 404);

    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('media.public');

Route::get('/', function () {
    $heroSetting = (object)[
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
        ->limit(4)
        ->get();

    $homeNews = \App\Models\News::where('status', 'published')
        ->with('translations')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->limit(3)
        ->get();

    $localComodites = \App\Models\LocalAmenity::where('is_published', true)
        ->with('translations')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    $homeTestimonials = \App\Models\Testimonial::where('is_published', true)
        ->with('translations')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    $aboutSectionSetting = (object)[
        'small_title' => 'À PROPOS DE NOUS',
        'title' => 'La Résidence Bella Vista',
        'lead' => 'Une conception du tourisme...',
        'description' => "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
        'signature' => 'L’équipe du Bella Vista',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $aboutSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
        ['section' => 'home_about'],
        [
            'small_title' => 'À PROPOS DE NOUS',
            'title' => 'La Résidence Bella Vista',
            'lead' => 'Une conception du tourisme...',
            'description' => "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
            'signature' => 'L’équipe du Bella Vista',
            'main_image' => 'img/home_2.jpg',
            'overlay_image' => 'img/home_1.jpg',
        ]
        );
        $aboutSectionSetting->loadMissing('translations');
    }

    $installationSectionSetting = (object)[
        'subtitle' => 'RÉsidence Bella vista',
        'title' => 'Installations principales',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('installation_section_settings')) {
        $installationSectionSetting = \App\Models\InstallationSectionSetting::firstOrCreate(
        ['section' => 'home_installations'],
        [
            'subtitle' => 'RÉsidence Bella vista',
            'title' => 'Installations principales',
        ]
        );
        $installationSectionSetting->loadMissing('translations');
    }

    $promoSetting = (object)[
        'is_enabled' => true,
        'start_date' => null,
        'end_date' => null,
        'subtitle' => 'Offre speciale',
        'title' => 'Profitez de votre sejour a Bella Vista',
        'text' => 'Decouvrez nos meilleures offres et disponibilites en quelques clics.',
        'button_link' => url('/appartements'),
        'image' => 'img/home_2.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('promo_section_settings')) {
        $promoSetting = \App\Models\PromoSectionSetting::firstOrCreate(
        ['section' => 'home_promo'],
        [
            'is_enabled' => true,
            'start_date' => null,
            'end_date' => null,
            'subtitle' => 'Offre speciale',
            'title' => 'Profitez de votre sejour a Bella Vista',
            'text' => 'Decouvrez nos meilleures offres et disponibilites en quelques clics.',
            'button_link' => url('/appartements'),
            'image' => 'img/home_2.jpg',
        ]
        );
        $promoSetting->loadMissing('translations');
    }

    return view('home', compact('heroSetting', 'installations', 'homeNews', 'localComodites', 'homeTestimonials', 'installationSectionSetting', 'aboutSectionSetting', 'promoSetting'));
});

Route::get('/contacts', function () {
    return view('contact');
});
Route::post('/contacts', [\App\Http\Controllers\ContactController::class , 'send'])->name('contact.send');

Route::get('/termsOfUse', function () {
    return view('terms-of-use');
})->name('termsOfUse.index');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy.index');

Route::get('/conditions', function () {
    return redirect()->route('termsOfUse.index');
})->name('conditions.index');

Route::get('/restaurant', function () {
    $localComodites = collect();
    if (\Illuminate\Support\Facades\Schema::hasTable('local_amenities')) {
        $localComodites = \App\Models\LocalAmenity::where('is_published', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    $localAmenitySectionSetting = (object)[
        'header_image' => 'img/home_2.jpg',
        'subtitle' => 'RÉsidence Bella vista',
        'title' => 'Restaurant',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('local_amenity_section_settings')) {
        $localAmenitySectionSetting = \App\Models\LocalAmenitySectionSetting::firstOrCreate(
        ['section' => 'about_local_amenities'],
        [
            'header_image' => 'img/home_2.jpg',
            'subtitle' => 'RÉsidence Bella vista',
            'title' => 'Restaurant',
        ]
        );
        $localAmenitySectionSetting->loadMissing('translations');
    }

    $aboutSectionSetting = (object)[
        'small_title' => 'À PROPOS DE NOUS',
        'title' => 'La Résidence Bella Vista',
        'lead' => 'Une conception du tourisme...',
        'description' => "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
        'signature' => 'L’équipe du Bella Vista',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('about_section_settings')) {
        $aboutSectionSetting = \App\Models\AboutSectionSetting::firstOrCreate(
        ['section' => 'home_about'],
        [
            'small_title' => 'À PROPOS DE NOUS',
            'title' => 'La Résidence Bella Vista',
            'lead' => 'Une conception du tourisme...',
            'description' => "Un établissement où se côtoient dans un subtil mélange, l’accueil chaleureux, la convivialité, le confort de chambres récemment rénovées dans un esprit moderne de grande qualité le tout associé à une table reconnue par le Titre de Maître Restaurateur.",
            'signature' => 'L’équipe du Bella Vista',
            'main_image' => 'img/home_2.jpg',
            'overlay_image' => 'img/home_1.jpg',
        ]
        );
        $aboutSectionSetting->loadMissing('translations');
    }

    return view('about', compact('aboutSectionSetting', 'localComodites', 'localAmenitySectionSetting'));
})->name('about.index');

Route::get('/appartements', function () {
    $rooms = \App\Models\Room::with('amenities.translations', 'translations')
        ->where('status', 'published')
        ->latest()
        ->get();

    $installations = \App\Models\Amenity::whereIn('scope', ['home', 'both'])
        ->with('translations')
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->limit(4)
        ->get();

    $installationSectionSetting = (object)[
        'subtitle' => 'RÉsidence Bella vista',
        'title' => 'Installations principales',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('installation_section_settings')) {
        $installationSectionSetting = \App\Models\InstallationSectionSetting::firstOrCreate(
        ['section' => 'home_installations'],
        [
            'subtitle' => 'RÉsidence Bella vista',
            'title' => 'Installations principales',
        ]
        );
        $installationSectionSetting->loadMissing('translations');
    }

    $appartmentPageSetting = (object)[
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

    return view('rooms', compact('rooms', 'appartmentPageSetting', 'installations', 'installationSectionSetting'));
})->name('appartements.index');

Route::get('/news', [\App\Http\Controllers\NewsController::class , 'index'])->name('news.index');

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
        Route::post('rooms/page-settings', [\App\Http\Controllers\Admin\RoomController::class , 'updatePageSettings'])->name('admin.rooms.page-settings.update');
        Route::resource('amenities', \App\Http\Controllers\Admin\AmenityController::class)->names('admin.amenities');
        Route::resource('installations', \App\Http\Controllers\Admin\InstallationController::class)->names('admin.installations');
        Route::post('installations/section-settings', [\App\Http\Controllers\Admin\InstallationController::class , 'updateSectionSettings'])->name('admin.installations.section-settings.update');
        Route::get('pool', [\App\Http\Controllers\Admin\PoolController::class, 'index'])->name('admin.pool.index');
        Route::get('maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('admin.maintenance.index');
        Route::post('maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'update'])->name('admin.maintenance.update');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->except(['show', 'destroy'])
            ->names('admin.users');
        Route::get('about', [\App\Http\Controllers\Admin\AboutController::class , 'index'])->name('admin.about.index');
        Route::post('about', [\App\Http\Controllers\Admin\AboutController::class , 'update'])->name('admin.about.update');
        Route::get('hero', [\App\Http\Controllers\Admin\HomeHeroController::class , 'index'])->name('admin.hero.index');
        Route::post('hero', [\App\Http\Controllers\Admin\HomeHeroController::class , 'update'])->name('admin.hero.update');
        Route::get('promo', [\App\Http\Controllers\Admin\PromoController::class , 'index'])->name('admin.promo.index');
        Route::post('promo', [\App\Http\Controllers\Admin\PromoController::class , 'update'])->name('admin.promo.update');
        Route::resource('comodites', \App\Http\Controllers\Admin\LocalAmenityController::class)->names('admin.comodites');
        Route::post('comodites/section-settings', [\App\Http\Controllers\Admin\LocalAmenityController::class , 'updateSectionSettings'])->name('admin.comodites.section-settings.update');
        Route::get('settings', [\App\Http\Controllers\Admin\SiteSettingController::class , 'index'])->name('admin.settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SiteSettingController::class , 'update'])->name('admin.settings.update');
        Route::get('translations', [\App\Http\Controllers\Admin\TranslationController::class , 'index'])->name('admin.translations.index');
        Route::post('translations', [\App\Http\Controllers\Admin\TranslationController::class , 'update'])->name('admin.translations.update');
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->names('admin.testimonials');
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->names('admin.news');
    });
});

Route::get('/rooms/{room:slug}', [\App\Http\Controllers\RoomController::class , 'show'])->name('rooms.show');
Route::get('/news/{news:slug}', [\App\Http\Controllers\NewsController::class , 'show'])->name('news.show');
