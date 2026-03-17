<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Residence Bella Vista</title>

    <!-- AdminLTE + Bootstrap via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/vendors.min.css') }}">

    <!-- Admin custom assets -->
    <link rel="stylesheet" href="{{ asset('xyres/admin/css/admin.css') }}">
</head>

<body class="admin hold-transition">
    <nav class="navbar navbar-expand-lg navbar-light bg-white admin-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/admin') }}">Admin</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-muted small">
                    <!-- cliquable -->
                    <a href="{{ url('/') }}" target="_blank">
                        {{ method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ??
                        'Residence Bella Vista') }}
                    </a>
                </span>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-2 col-md-3 bg-white border-end min-vh-100 py-4">
                <div class="fw-semibold text-uppercase small text-muted px-3 mb-3">Navigation</div>
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/admin') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.rooms.index') }}">Chambres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.amenities.index') }}">Équipements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.installations.index') }}">Installations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.hero.index') }}">Hero accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.about.index') }}">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.promo.index') }}">Promo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.comodites.index') }}">Restaurant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.pool.index') }}">Piscine</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.testimonials.index') }}">Témoignages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.news.index') }}">Actualités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.settings.index') }}">Paramètres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.translations.index') }}">Traductions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#0">Galerie</a>
                    </li>
                </ul>
            </aside>
            <main class="col-lg-10 col-md-9 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <footer class="container-fluid pb-4 admin-footer">
        <div class="row">
            <div class="col-lg-10 offset-lg-2 col-md-9 offset-md-3">
                © {{ date('Y') }} Residence Bella Vista
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('xyres/admin/js/admin.js') }}"></script>
</body>

</html>
