<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ?? 'Lasanta') }}</title>
    <link rel="icon" href="{{ theme_asset('img/favicon.ico') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('css/plugins/font-awesome-pro.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ theme_asset('css/plugins.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ theme_asset('css/custom.css') }}?v={{ time() }}">
    {!! $siteSetting->custom_head_scripts ?? '' !!}
</head>
<body class="front-theme-{{ current_front_theme() }}">
    <div class="preloader">
        <div class="centered">
            <div class="cont">
                <div class="loader-circle"></div>
                <div class="loader-line-mask">
                    <div class="loader-line"></div></div>
                <!-- <img src="{{ theme_asset('img/preloader.png') }}" alt=""> -->
            </div>
        </div>
    </div>

    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    @include('themes.lasanta.partials.layout.nav')

    @yield('content')

    @include('themes.lasanta.partials.layout.footer')

    <script src="{{ theme_asset('js/jquery-3.7.1.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/jquery-migrate-3.4.1.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/modernizr-2.6.2.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/imagesloaded.pkgd.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/jquery.isotope.v3.0.2.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/popper.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/bootstrap.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/scrollIt.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/jquery.waypoints.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/owl.carousel.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/jquery.stellar.min.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/jquery.magnific-popup.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/YouTubePopUp.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/select2.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/datepicker.js') }}?v={{ time() }}"></script>
    <script src="{{ theme_asset('js/custom.js') }}?v={{ time() }}"></script>
    @stack('scripts')
</body>
</html>
