<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Residence Bella Vista</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
        href="{{ asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
        href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
        href="{{ asset('img/apple-touch-icon-144x144-precomposed.png') }}">

    <!-- AdminLTE + Bootstrap via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/vendors.min.css') }}">

    <!-- Admin custom assets -->
    <link rel="stylesheet" href="{{ asset('xyres/admin/css/admin.css') }}">
    @stack('css')
</head>

@php
    $adminNavGroups = [
        [
            'title' => 'Vue d’ensemble',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => route('admin.dashboard'),
                    'active' => request()->routeIs('admin.dashboard'),
                    'icon' => 'bi-grid-1x2-fill',
                ],
            ],
        ],
        [
            'title' => 'Page d’accueil',
            'items' => [
                [
                    'label' => 'Page d’accueil',
                    'icon' => 'bi-house-door',
                    'active' => request()->routeIs('admin.hero.*')
                        || request()->routeIs('admin.installations.*')
                        || request()->routeIs('admin.promo.*')
                        || request()->routeIs('admin.about.*')
                        || request()->routeIs('admin.testimonials.*')
                        || request()->routeIs('admin.comodites.*'),
                    'children' => [
                        ['label' => 'Hero accueil', 'route' => route('admin.hero.index'), 'active' => request()->routeIs('admin.hero.*'), 'icon' => 'bi-play-circle'],
                        ['label' => 'Installations', 'route' => route('admin.installations.index'), 'active' => request()->routeIs('admin.installations.*'), 'icon' => 'icon-hotel-reception'],
                        ['label' => 'À propos', 'route' => route('admin.about.index'), 'active' => request()->routeIs('admin.about.*'), 'icon' => 'bi-info-circle'],
                        ['label' => 'Promo', 'route' => route('admin.promo.index'), 'active' => request()->routeIs('admin.promo.*'), 'icon' => 'bi-ticket-perforated'],
                        ['label' => 'Commodités', 'route' => route('admin.comodites.index'), 'active' => request()->routeIs('admin.comodites.*'), 'icon' => 'bi-geo-alt'],
                        ['label' => 'Témoignages', 'route' => route('admin.testimonials.index'), 'active' => request()->routeIs('admin.testimonials.*'), 'icon' => 'bi-chat-quote'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Pages',
            'items' => [
                ['label' => 'Chambres', 'route' => route('admin.rooms.index'), 'active' => request()->routeIs('admin.rooms.*'), 'icon' => 'bi-door-open'],
                ['label' => 'Restaurant', 'route' => route('admin.restaurant.index'), 'active' => request()->routeIs('admin.restaurant.*'), 'icon' => 'icon-hotel-restaurant'],
                ['label' => 'Piscine', 'route' => route('admin.pool.index'), 'active' => request()->routeIs('admin.pool.*'), 'icon' => 'icon-hotel-swimming_pool'],
                ['label' => 'Contact', 'route' => route('admin.contact.index'), 'active' => request()->routeIs('admin.contact.*'), 'icon' => 'bi-envelope'],
                ['label' => 'Actualités', 'route' => route('admin.news.index'), 'active' => request()->routeIs('admin.news.*'), 'icon' => 'bi-megaphone'],
                ['label' => 'Conditions & Confidentialité', 'route' => route('admin.legal.index'), 'active' => request()->routeIs('admin.legal.*'), 'icon' => 'bi-shield-check'],
            ],
        ],
        [
            'title' => 'Contenu',
            'items' => [
                ['label' => 'Équipements', 'route' => route('admin.amenities.index'), 'active' => request()->routeIs('admin.amenities.*'), 'icon' => 'bi-stars'],
                ['label' => 'Maintenance', 'route' => route('admin.maintenance.index'), 'active' => request()->routeIs('admin.maintenance.*'), 'icon' => 'bi-shield-lock'],
                ['label' => 'Utilisateurs', 'route' => route('admin.users.index'), 'active' => request()->routeIs('admin.users.*'), 'icon' => 'bi-people'],
                ['label' => 'Paramètres', 'route' => route('admin.settings.index'), 'active' => request()->routeIs('admin.settings.*'), 'icon' => 'bi-gear'],
                ['label' => 'Traductions', 'route' => route('admin.translations.index'), 'active' => request()->routeIs('admin.translations.*'), 'icon' => 'bi-translate'],
                // ['label' => 'Galerie', 'route' => '#0', 'active' => false, 'icon' => 'bi-images'],
            ],
        ],
    ];
@endphp

<body class="admin">
    <div class="admin-app">
        <aside class="admin-sidebar">
            <a href="{{ url('/admin') }}" class="admin-brand">
                <img src="{{ asset('img/logo_sticky.png') }}" alt="Residence Bella Vista">
                <div class="admin-brand__copy">
                    <strong>Residence Bella Vista</strong>
                    <span>Back-office</span>
                </div>
            </a>

            <div class="admin-sidebar__inner">
                @foreach($adminNavGroups as $group)
                    <div class="admin-nav-group">
                        <div class="admin-nav-group__title">{{ $group['title'] }}</div>
                        <ul class="admin-nav">
                            @foreach($group['items'] as $item)
                                <li class="admin-nav__item {{ $item['active'] ? 'is-active' : '' }}">
                                    @if(!empty($item['children']))
                                        <details class="admin-subnav" {{ $item['active'] ? 'open' : '' }}>
                                            <summary class="admin-nav__link">
                                                <span class="admin-nav__icon"><i class="{{ $item['icon'] }}"></i></span>
                                                <span class="admin-nav__label">{{ $item['label'] }}</span>
                                                <span class="admin-nav__caret"><i class="bi bi-chevron-down"></i></span>
                                            </summary>
                                            <ul class="admin-subnav__list">
                                                @foreach($item['children'] as $child)
                                                    <li>
                                                        <a href="{{ $child['route'] }}"
                                                            class="admin-subnav__link {{ $child['active'] ? 'is-active' : '' }}">
                                                            <span class="admin-subnav__icon"><i class="{{ $child['icon'] }}"></i></span>
                                                            <span>{{ $child['label'] }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </details>
                                    @else
                                        <a class="admin-nav__link" href="{{ $item['route'] }}">
                                            <span class="admin-nav__icon"><i class="{{ $item['icon'] }}"></i></span>
                                            <span class="admin-nav__label">{{ $item['label'] }}</span>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </aside>

        <div class="admin-main">
            <nav class="admin-topbar">
                <div class="admin-topbar__left">
                    <div>
                        <span class="admin-topbar__eyebrow">Administration</span>
                        <div class="admin-topbar__title">@yield('title', 'Admin')</div>
                    </div>
                </div>
                <div class="admin-topbar__right">
                    <a href="{{ url('/') }}" class="admin-topbar__site" target="_blank" rel="noopener">
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>{{ method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ?? 'Residence Bella Vista') }}</span>
                    </a>
                    <form action="{{ route('admin.logout') }}" method="post" class="admin-topbar__logout">
                        @csrf
                        <button type="submit" class="admin-topbar__logout-button">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <footer class="admin-footer">
        © {{ date('Y') }} Residence Bella Vista
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <script src="{{ asset('xyres/admin/js/admin.js') }}"></script>
    @stack('scripts')
</body>

</html>