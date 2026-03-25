<nav id="mainNav">
    @php
    $locale = app()->getLocale();
    $flags = [
    'fr' => '🇫🇷',
    'en' => '🇬🇧',
    'de' => '🇩🇪',
    'nl' => '🇳🇱',
    ];
    $activeFlag = $flags[$locale] ?? '🌐';
    $labels = [
    'fr' => [
    'home' => 'Accueil',
    'apartments' => 'Appartements',
    'restaurant' => 'Restaurant',
    'pool' => 'Piscine',
    'news' => 'Actualités',
    'contact' => 'Contacts',
    'book' => 'Réserver',
    ],
    'en' => [
    'home' => 'Home',
    'apartments' => 'Apartments',
    'restaurant' => 'Restaurant',
    'pool' => 'Pool',
    'news' => 'News',
    'contact' => 'Contact',
    'book' => 'Book now',
    ],
    'de' => [
    'home' => 'Home',
    'apartments' => 'Apartments',
    'restaurant' => 'Restaurant',
    'pool' => 'Pool',
    'news' => 'Neuigkeiten',
    'contact' => 'Kontakt',
    'book' => 'Buchen',
    ],
    'nl' => [
    'home' => 'Home',
    'apartments' => 'Appartementen',
    'restaurant' => 'Restaurant',
    'pool' => 'Zwembad',
    'news' => 'Nieuws',
    'contact' => 'Contact',
    'book' => 'Boeken',
    ],
    ];
    $t = $labels[$locale] ?? $labels['en'];
    $isHome = request()->routeIs('home') || request()->is('/');
    $isApartments = request()->routeIs('appartements.index') || request()->routeIs('rooms.show') || request()->is('appartements') || request()->is('rooms/*');
    $isRestaurant = request()->routeIs('about.index') || request()->is('restaurant');
    $isPool = request()->routeIs('pool.index') || request()->is('piscine');
    $isNews = request()->routeIs('news.index') || request()->routeIs('news.show') || request()->is('news') || request()->is('news/*');
    $isContact = request()->is('contacts');
    @endphp
    <ul>
        <li><a href="{{ url('/') }}" class="animated_link {{ $isHome ? 'active' : '' }}">{{ $t['home'] }}</a></li>
        <li><a href="{{ url('/appartements') }}" class="animated_link {{ $isApartments ? 'active' : '' }}">{{ $t['apartments'] }}</a></li>
        <li><a href="{{ route('about.index') }}" class="animated_link {{ $isRestaurant ? 'active' : '' }}">{{ $t['restaurant'] }}</a></li>
        <li><a href="{{ route('pool.index') }}" class="animated_link {{ $isPool ? 'active' : '' }}">{{ $t['pool'] }}</a></li>
        <li><a href="{{ url('/news') }}" class="animated_link {{ $isNews ? 'active' : '' }}">{{ $t['news'] }}</a></li>
        <li><a href="{{ url('/contacts') }}" class="animated_link {{ $isContact ? 'active' : '' }}">{{ $t['contact'] }}</a></li>
        <li>
            <details class="lang-picker">
                <summary class="lang-picker__summary" aria-label="Choisir la langue">
                    <span class="lang-picker__flag">{{ $activeFlag }}</span>
                </summary>
                <div class="lang-picker__menu">
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'fr']) }}" class="lang-picker__item"
                        aria-label="Français"><span class="lang-picker__flag">🇫🇷</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="lang-picker__item"
                        aria-label="English"><span class="lang-picker__flag">🇬🇧</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'de']) }}" class="lang-picker__item"
                        aria-label="Deutsch"><span class="lang-picker__flag">🇩🇪</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'nl']) }}" class="lang-picker__item"
                        aria-label="Nederlands"><span class="lang-picker__flag">🇳🇱</span></a>
                </div>
            </details>
        </li>
        <li><a href="{{ $heroButtonLink }}" class="btn_1" target="{{ $heroButtonTarget }}"
                @if($heroButtonTarget==='_blank' ) rel="noopener" @endif>{{ $t['book'] }}</a></li>
    </ul>
</nav>
