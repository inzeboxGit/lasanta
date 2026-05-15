@php
    $locale = app()->getLocale();
    $languages = [
        'fr' => ['label' => 'Français', 'code' => 'FR', 'flag' => asset('img/flags/fr.svg')],
        'en' => ['label' => 'English', 'code' => 'EN', 'flag' => asset('img/flags/gb.svg')],
        'de' => ['label' => 'Deutsch', 'code' => 'DE', 'flag' => asset('img/flags/de.svg')],
        'it' => ['label' => 'Italiano', 'code' => 'IT', 'flag' => asset('img/flags/it.svg')],
    ];
    $activeLanguage = $languages[$locale] ?? $languages['en'];
    $labels = [
        'fr' => [
            'home' => 'Accueil',
            'appartement' => 'Nos chambres',
            'auberge' => "Restaurant",
            'piscine' => 'Piscine',
            'news' => 'Actualités',
            'contact' => 'Contact',
            'book' => 'Réserver',
        ],
        'en' => [
            'home' => 'Home',
            'appartement' => 'Our Rooms',
            'auberge' => 'Restaurant',
            'piscine' => 'Pool',
            'news' => 'News',
            'contact' => 'Contact',
            'book' => 'Book now',
        ],
        'de' => [
            'home' => 'Startseite',
            'appartement' => 'Unsere Zimmer',
            'auberge' => 'Restaurant',
            'piscine' => 'Pool',
            'news' => 'Neuigkeiten',
            'contact' => 'Kontakt',
            'book' => 'Buchen',
        ],
        'it' => [
            'home' => 'Home',
            'appartement' => 'Le nostre camere',
            'auberge' => "Ristorante",
            'piscine' => 'Piscina',
            'news' => 'News',
            'contact' => 'Contatti',
            'book' => 'Prenota',
        ],
    ];
    $t = $labels[$locale] ?? $labels['en'];
    $isHome = request()->url() === url('/');
    $isApartments = request()->routeIs('appartements.index') || request()->routeIs('rooms.show');
    $isRestaurant = request()->routeIs('restaurant.index');
    $isPool = request()->routeIs('pool.index');
    $isActivites = request()->routeIs('activites.index');
    $isNews = request()->routeIs('news.index') || request()->routeIs('news.show');
    $isContact = request()->is('contacts');
@endphp
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <div class="logo-wrapper">
            <a class="logo" href="{{ url('/') }}">
                <img src="{{ theme_asset('img/logo.png') }}" class="logo-img"
                    alt="{{ method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ?? 'Lasanta') }}">
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fa-light fa-bars"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link {{ $isHome ? 'active' : '' }}"
                        href="{{ url('/') }}">{{ $t['home'] }}</a>
                </li>
                <li class="nav-item"><a class="nav-link {{ $isApartments ? 'active' : '' }}"
                        href="{{ route('appartements.index') }}">{{ $t['appartement'] }}</a></li>
                <li class="nav-item"><a class="nav-link {{ $isRestaurant ? 'active' : '' }}"
                        href="{{ route('restaurant.index') }}">{{ $t['auberge'] }}</a></li>
                <li class="nav-item"><a class="nav-link {{ $isPool ? 'active' : '' }}"
                        href="{{ route('pool.index') }}">{{ $t['piscine'] }}</a></li>
                <li class="nav-item"><a class="nav-link {{ $isNews ? 'active' : '' }}"
                        href="{{ route('news.index') }}">{{ $t['news'] }}</a></li>
                <li class="nav-item"><a class="nav-link {{ $isContact ? 'active' : '' }}"
                        href="{{ url('/contacts') }}">{{ $t['contact'] }}</a></li>
            </ul>
            <div class="navbar-right">
                <div class="dropdown language-dropdown d-inline-block me-2">
                    <button class="btn btn-link nav-link dropdown-toggle p-0 border-0 shadow-none" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="Choisir la langue">
                        <img src="{{ $activeLanguage['flag'] }}" alt="{{ $activeLanguage['label'] }}"
                            style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach($languages as $langKey => $language)
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ $locale === $langKey ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['lang' => $langKey]) }}"
                                    aria-label="{{ $language['label'] }}">
                                    <img src="{{ $language['flag'] }}" alt="{{ $language['label'] }}"
                                        style="width: 18px; height: 18px; border-radius: 50%; object-fit: cover;">
                                    <span>{{ $language['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="button"><a target="_blank"
                        href="https://smartbooking.hotelnet.biz/home/main?hotel=5191&channel=0000&lingua={{ strtoupper($locale) }}">
                        <i class="fa-light fa-calendar-check"></i> {{ $t['book'] }}</a></div>
            </div>
        </div>
    </div>
</nav>