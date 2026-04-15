<!DOCTYPE html>
@php
    $siteSetting = (object) [
        'site_name' => '',
        'address' => '',
        'email' => '',
        'phone_primary' => '',
        'phone_secondary' => '',
        'facebook_url' => '',
        'instagram_url' => '',
        'whatsapp_url' => '',
        'twitter_url' => '',
        'footer_background_image' => '',
    ];

    if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
        $siteSettingDefaults = [
            'site_name' => '',
            'address' => '',
            'email' => '',
            'phone_primary' => '',
            'phone_secondary' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'whatsapp_url' => '',
            'twitter_url' => '',
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('site_settings', 'footer_background_image')) {
            $siteSettingDefaults['footer_background_image'] = '';
        }

        $siteSetting = \App\Models\SiteSetting::firstOrCreate(
            ['setting_key' => 'general'],
            $siteSettingDefaults
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
                'small_title' => '',
                'title' => '',
                'button_link' => '',
                'button_target' => '_self',
                'background_type' => 'video',
                'background_video' => '',
                'youtube_video_url' => null,
                'background_image' => '',
            ]
        );
    }

    $heroButtonLink = $heroNavSetting->button_link ?? '';
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
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="residencebellavista.fr">
    <title>{{ method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ?? '') }}
    </title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
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
    <link href="{{ asset('css/bootstrap.min.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('css/vendors.min.css') }}?v={{ time() }}" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('css/custom.css') }}?v={{ time() }}" rel="stylesheet">

    {!! $siteSetting->custom_head_scripts ?? '' !!}
</head>

<body>

    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div><!-- /Page Preload -->

    <header class="menu_v4 fixed_header">
        <div class="layer"></div>
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
        </div>
    </header>

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
    <script src="{{ asset('js/common_scripts.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/common_functions.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/datepicker_search.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/datepicker_inline.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('phpmailer/validate.js') }}?v={{ filemtime(public_path('phpmailer/validate.js')) }}"></script>
    @if($showPromoModal)
        <script src="{{ asset('js/modal_popup.js') }}"></script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.querySelector('header.no_sticky_header');

            if (!header) return;

            const syncHeaderState = function () {
                header.classList.toggle('is-scrolled', window.scrollY > 10);
            };

            window.addEventListener('scroll', syncHeaderState, { passive: true });
            syncHeaderState();
        });
    </script>
    @stack('scripts')

</body>

</html>
