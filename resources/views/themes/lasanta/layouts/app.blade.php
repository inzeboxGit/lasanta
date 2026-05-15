<!DOCTYPE html>
@php
    $currentUrl = rtrim(request()->url(), '/');
    $homeUrl = rtrim(url('/'), '/');
    $isHomePage = $currentUrl === $homeUrl;

    $showPromoModal = $isHomePage && isset($promoSetting) && ($promoSetting->is_enabled ?? false);
    $themeVersion = static function (string $path): int {
        $absolutePath = public_path($path);

        return is_file($absolutePath) ? filemtime($absolutePath) : time();
    };
@endphp
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
    <link rel="stylesheet" href="{{ theme_asset('css/plugins/font-awesome-pro.css') }}?v={{ $themeVersion('themes/lasanta/css/plugins/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/plugins.css') }}?v={{ $themeVersion('themes/lasanta/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}?v={{ $themeVersion('themes/lasanta/css/style.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/custom.css') }}?v={{ $themeVersion('themes/lasanta/css/custom.css') }}">
    {!! $siteSetting->custom_head_scripts ?? '' !!}
    @stack('styles')
</head>
<body class="front-theme-{{ current_front_theme() }}">
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    @include('themes.lasanta.partials.layout.nav')

    @yield('content')

    @if($showPromoModal)
        @include('themes.lasanta.partials.layout.home-advertise-modal')
    @endif

    @include('themes.lasanta.partials.layout.footer')

    <script src="{{ theme_asset('js/jquery-3.7.1.min.js') }}?v={{ $themeVersion('themes/lasanta/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ theme_asset('js/jquery-migrate-3.4.1.min.js') }}?v={{ $themeVersion('themes/lasanta/js/jquery-migrate-3.4.1.min.js') }}"></script>
    <script src="{{ theme_asset('js/modernizr-2.6.2.min.js') }}?v={{ $themeVersion('themes/lasanta/js/modernizr-2.6.2.min.js') }}"></script>
    <script src="{{ theme_asset('js/imagesloaded.pkgd.min.js') }}?v={{ $themeVersion('themes/lasanta/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ theme_asset('js/jquery.isotope.v3.0.2.js') }}?v={{ $themeVersion('themes/lasanta/js/jquery.isotope.v3.0.2.js') }}"></script>
    <script src="{{ theme_asset('js/popper.min.js') }}?v={{ $themeVersion('themes/lasanta/js/popper.min.js') }}"></script>
    <script src="{{ theme_asset('js/bootstrap.min.js') }}?v={{ $themeVersion('themes/lasanta/js/bootstrap.min.js') }}"></script>
    <script src="{{ theme_asset('js/scrollIt.min.js') }}?v={{ $themeVersion('themes/lasanta/js/scrollIt.min.js') }}"></script>
    <script src="{{ theme_asset('js/jquery.waypoints.min.js') }}?v={{ $themeVersion('themes/lasanta/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ theme_asset('js/owl.carousel.min.js') }}?v={{ $themeVersion('themes/lasanta/js/owl.carousel.min.js') }}"></script>
    <script src="{{ theme_asset('js/jquery.stellar.min.js') }}?v={{ $themeVersion('themes/lasanta/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ theme_asset('js/jquery.magnific-popup.js') }}?v={{ $themeVersion('themes/lasanta/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ theme_asset('js/YouTubePopUp.js') }}?v={{ $themeVersion('themes/lasanta/js/YouTubePopUp.js') }}"></script>
    <script src="{{ theme_asset('js/select2.js') }}?v={{ $themeVersion('themes/lasanta/js/select2.js') }}"></script>
    <script src="{{ theme_asset('js/datepicker.js') }}?v={{ $themeVersion('themes/lasanta/js/datepicker.js') }}"></script>
    <script src="{{ theme_asset('js/custom.js') }}?v={{ $themeVersion('themes/lasanta/js/custom.js') }}"></script>
    @if($showPromoModal)
        <script src="{{ asset('js/modal_popup.js') }}?v={{ $themeVersion('js/modal_popup.js') }}"></script>
    @endif

    <script>
    $(document).ready(function() {
        // On s'assure que le datepicker utilise le format JJ/MM/AAAA
        if ($.fn.datepicker) {
            $(".datepicker").datepicker("option", "dateFormat", "dd/mm/yy");
        }

        // Fonction universelle pour soumettre à HotelNet
        function submitToHotelNet(checkInId, checkOutId, adultsId, childrenId, roomsId) {
            var checkInStr = $(checkInId).val();
            var checkOutStr = $(checkOutId).val();

            if(!checkInStr || !checkOutStr) {
                alert('Veuillez sélectionner vos dates de séjour.');
                return;
            }

            // Formater les dates pour HotelNet (AAAA-MM-JJ)
            function formatDate(str) {
                var parts = str.split('/');
                if(parts.length === 3) {
                    // Avec format dd/mm/yy : parts[0]=day, parts[1]=month, parts[2]=year
                    return parts[2] + '-' + parts[1] + '-' + parts[0];
                }
                return str;
            }

            var arrivo = formatDate(checkInStr);
            var partenza = formatDate(checkOutStr);
            var adults = $(adultsId).val() || 2;
            var children = $(childrenId).val() || 0;
            var rooms = $(roomsId).val() || 1;
            var language = '{{ app()->getLocale() == "en" ? "GB" : strtoupper(app()->getLocale()) }}';
            
            // Format HotelNet: [Rooms]![Adults](-[Children])
            var camere = rooms + '!' + adults;
            if (parseInt(children) > 0) {
                camere += '-' + children;
            }

            var hotelId = '5191';
            var searchUrl = "https://smartbooking.hotelnet.biz/home/accomodation?" +
                            "hotel=" + hotelId +
                            "&channel=0000" +
                            "&lingua=" + language +
                            "&arrivo=" + arrivo +
                            "&partenza=" + partenza +
                            "&camere=" + camere;

            window.open(searchUrl, '_blank');
        }

        // Branchement du formulaire Home
        $('#hnet-booking-form').on('submit', function(e) {
            e.preventDefault();
            submitToHotelNet('#hnet-check-in', '#hnet-check-out', '#hnet-adults', '#hnet-children', '#hnet-rooms');
        });

        // Branchement du formulaire Footer
        $('#hnet-booking-footer').on('submit', function(e) {
            e.preventDefault();
            submitToHotelNet('#hnet-footer-check-in', '#hnet-footer-check-out', '#hnet-footer-adults', '#hnet-footer-children', '#hnet-footer-rooms');
        });
    });
    </script>

    @stack('scripts')
</body>
</html>
