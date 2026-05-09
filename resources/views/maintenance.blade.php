<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site en maintenance | {{ method_exists($siteSetting, 't') ? $siteSetting->t('site_name') : ($siteSetting->site_name ?? 'Residence Bella Vista') }}</title>
    <link rel="shortcut icon" href="{{ theme_asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ theme_asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ theme_asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ theme_asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ theme_asset('img/apple-touch-icon-144x144-precomposed.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">
    <style>
        body { min-height: 100vh; margin: 0; background: linear-gradient(135deg, #f7efe4 0%, #fefcf8 100%); color: #22303a; }
        .maintenance-shell { min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        .maintenance-card { max-width: 640px; width: 100%; background: rgba(255,255,255,.92); border: 1px solid rgba(34,48,58,.08); border-radius: 24px; box-shadow: 0 24px 60px rgba(29,35,40,.1); padding: 40px 32px; text-align: center; }
        .maintenance-card img { width: 88px; margin: 0 auto 20px; }
        .maintenance-card h1 { font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 12px; }
        .maintenance-card p { color: #66717a; margin-bottom: 10px; }
    </style>
</head>
<body class="front-theme-{{ current_front_theme() }}">
    @php
        $defaultMaintenanceMessage = "Le site est temporairement indisponible pour cause de mise a jour.\nMerci de revenir un peu plus tard.";
        $maintenanceMessage = method_exists($siteSetting, 't')
            ? ($siteSetting->t('maintenance_message') ?: ($siteSetting->maintenance_message ?? $defaultMaintenanceMessage))
            : ($siteSetting->maintenance_message ?? $defaultMaintenanceMessage);
    @endphp
    <main class="maintenance-shell">
        <div class="maintenance-card">
            <img src="{{ theme_asset('img/logo_sticky.png') }}" alt="Residence Bella Vista">
            <span class="dashboard-eyebrow">Maintenance</span>
            <h1>Site en maintenance</h1>
            <p>{!! nl2br(e($maintenanceMessage)) !!}</p>
            @if(!empty($siteSetting->email ?? null))
                <p class="mb-0">Contact : <a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a></p>
            @endif
        </div>
    </main>
</body>
</html>
