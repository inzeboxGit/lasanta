<nav id="mainNav">
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
            'it' => [
                'home' => 'Home',
                'apartments' => 'Appartamenti',
                'restaurant' => 'Ristorante',
                'pool' => 'Piscina',
                'news' => 'News',
                'contact' => 'Contatti',
                'book' => 'Prenota',
            ],
        ];
        $t = $labels[$locale] ?? $labels['en'];
        $isHome = request()->routeIs('home') || request()->is('/');
        $isApartments = request()->routeIs('appartements.index') || request()->routeIs('rooms.show') || request()->is('appartements') || request()->is('rooms/*');
        $isRestaurant = request()->routeIs('restaurant.index') || request()->is('restaurant');
        $isPool = request()->routeIs('pool.index') || request()->is('piscine');
        $isNews = request()->routeIs('news.index') || request()->routeIs('news.show') || request()->is('news') || request()->is('news/*');
        $isContact = request()->is('contacts');
    @endphp
    <ul>
        <li><a href="{{ url('/') }}" class="animated_link {{ $isHome ? 'active' : '' }}">{{ $t['home'] }}</a></li>
        <li><a href="{{ url('/appartements') }}"
                class="animated_link {{ $isApartments ? 'active' : '' }}">{{ $t['apartments'] }}</a></li>
        <li><a href="{{ route('restaurant.index') }}"
                class="animated_link {{ $isRestaurant ? 'active' : '' }}">{{ $t['restaurant'] }}</a></li>
        <li><a href="{{ route('pool.index') }}" class="animated_link {{ $isPool ? 'active' : '' }}">{{ $t['pool'] }}</a>
        </li>
        <li><a href="{{ url('/news') }}" class="animated_link {{ $isNews ? 'active' : '' }}">{{ $t['news'] }}</a></li>
        <li><a href="{{ url('/contacts') }}"
                class="animated_link {{ $isContact ? 'active' : '' }}">{{ $t['contact'] }}</a></li>
        <li class="nav-lang-item">
            <details class="lang-picker">
                <summary class="lang-picker__summary" aria-label="Choisir la langue">
                    <span class="lang-picker__flag">
                        <img src="{{ $activeLanguage['flag'] }}" alt="{{ $activeLanguage['label'] }}"
                            class="lang-picker__flag-image">
                    </span>
                </summary>
                <div class="lang-picker__menu">
                    @foreach($languages as $langKey => $language)
                        <a href="{{ request()->fullUrlWithQuery(['lang' => $langKey]) }}"
                            class="lang-picker__item {{ $locale === $langKey ? 'is-active' : '' }}"
                            aria-label="{{ $language['label'] }}">
                            <span class="lang-picker__flag">
                                <img src="{{ $language['flag'] }}" alt="{{ $language['label'] }}"
                                    class="lang-picker__flag-image">
                            </span>
                        </a>
                    @endforeach
                </div>
            </details>
            <div class="lang-picker-mobile" aria-label="Choisir la langue">
                @foreach($languages as $langKey => $language)
                    <a href="{{ request()->fullUrlWithQuery(['lang' => $langKey]) }}"
                        class="lang-picker-mobile__item {{ $locale === $langKey ? 'is-active' : '' }}"
                        aria-label="{{ $language['label'] }}">
                        <span class="lang-picker__flag">
                            <img src="{{ $language['flag'] }}" alt="{{ $language['label'] }}"
                                class="lang-picker__flag-image">
                        </span>
                        <span class="lang-picker-mobile__code">{{-- $language['code'] --}}</span>
                    </a>
                @endforeach
            </div>
        </li>
        <li><a href="{{ $heroButtonLink }}" class="btn_1 nav-book-btn" target="{{ $heroButtonTarget }}"
                @if($heroButtonTarget === '_blank') rel="noopener" @endif>{{ $t['book'] }}</a></li>
    </ul>
</nav>