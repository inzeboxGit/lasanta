<!DOCTYPE html>
@php
    $siteSetting = (object) [
        'site_name' => 'Residence Bella Vista',
        'address' => "3 place de l'Eglise, 20220 SANTA REPARATA DI BALAGNA",
        'email' => 'info@residence-bellavista.com',
        'phone_primary' => '04 95 00 00 00',
        'phone_secondary' => '',
        'facebook_url' => '',
        'instagram_url' => '',
        'whatsapp_url' => '',
        'twitter_url' => '',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
        $siteSetting = \App\Models\SiteSetting::firstOrCreate(
            ['setting_key' => 'general'],
            [
                'site_name' => 'Residence Bella Vista',
                'address' => "3 place de l'Eglise, 20220 SANTA REPARATA DI BALAGNA",
                'email' => 'info@residence-bellavista.com',
                'phone_primary' => '04 95 00 00 00',
                'phone_secondary' => '',
                'facebook_url' => '',
                'instagram_url' => '',
                'whatsapp_url' => '',
                'twitter_url' => '',
            ]
        );

        $siteSetting->loadMissing('translations');
    }
@endphp
@php
    $isHomePage = request()->url() === url('/');
    $heroNavSetting = $heroSetting ?? null;

    if (!$heroNavSetting && \Illuminate\Support\Facades\Schema::hasTable('home_hero_settings')) {
        $heroNavSetting = \App\Models\HomeHeroSetting::firstOrCreate(
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
    }

    $heroButtonLink = $heroNavSetting->button_link ?? '/appartements';
    $heroButtonTarget = $heroNavSetting->button_target ?? '_self';
    $today = now()->startOfDay();
    $promoStartsAt = !empty($promoSetting->start_date ?? null)
        ? \Illuminate\Support\Carbon::parse($promoSetting->start_date)->startOfDay()
        : null;
    $promoEndsAt = !empty($promoSetting->end_date ?? null)
        ? \Illuminate\Support\Carbon::parse($promoSetting->end_date)->endOfDay()
        : null;
    $promoIsInDateRange = (!$promoStartsAt || $today->greaterThanOrEqualTo($promoStartsAt))
        && (!$promoEndsAt || $today->lessThanOrEqualTo($promoEndsAt));
    $showPromoModal = $isHomePage && isset($promoSetting) && ($promoSetting->is_enabled ?? false) && $promoIsInDateRange;
@endphp
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="residencebellavista.fr">
    <title>{{ method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ?? 'Residence
        Bella Vista') }}</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
        href="{{ asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
        href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
        href="{{ asset('img/apple-touch-icon-144x144-precomposed.png') }}">

    <!-- GOOGLE WEB FONT-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors.min.css') }}" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>

    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div><!-- /Page Preload -->

    <header class="fixed_header menu_v4">
        <div class="layer"></div><!-- Opacity Mask -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4">
                    <a href="{{ url('/') }}" class="logo_normal"><img src="{{ asset('img/logo.png') }}" width="135"
                            alt=""></a>
                    <a href="{{ url('/') }}" class="logo_sticky"><img src="{{ asset('img/logo_sticky.png') }}"
                            width="155" alt=""></a>
                </div>
                <div class="col-8">
                    <div class="main-menu">
                        <a href="#" class="closebt open_close_menu"><i class="bi bi-x"></i></a>
                        <div class="logo_panel"><img src="{{ asset('img/logo_sticky.png') }}" width="155" alt=""></div>
                        @include('partials.layout.nav')
                    </div>
                    <div class="hamburger_2 open_close_menu float-end">
                        <div class="hamburger__box">
                            <div class="hamburger__inner"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

    @yield('content')

    @include('partials.layout.footer')

    @if($showPromoModal)
        @include('partials.layout.home-advertise-modal')
    @endif

    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- /back to top -->

    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('js/common_scripts.js') }}"></script>
    <script src="{{ asset('js/common_functions.js') }}"></script>
    <script src="{{ asset('js/datepicker_search.js') }}"></script>
    <script src="{{ asset('js/datepicker_inline.js') }}"></script>
    <script src="{{ asset('phpmailer/validate.js') }}?v={{ filemtime(public_path('phpmailer/validate.js')) }}"></script>
    @if($showPromoModal)
        <script src="{{ asset('js/modal_popup.js') }}"></script>
    @endif
    @stack('scripts')

</body>

</html>
