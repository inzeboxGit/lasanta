<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion admin | Residence Bella Vista</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('img/apple-touch-icon-144x144-precomposed.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('xyres/admin/css/admin.css') }}">
</head>
<body class="admin admin-auth">
    <main class="admin-auth__shell">
        <div class="admin-auth__card">
            <a href="{{ url('/') }}" class="admin-brand admin-auth__brand">
                <img src="{{ asset('img/logo_sticky.png') }}" alt="Residence Bella Vista">
                <div class="admin-brand__copy">
                    <strong>Residence Bella Vista</strong>
                    <span>Connexion administration</span>
                </div>
            </a>

            <div class="admin-auth__content">
                <div class="admin-auth__heading">
                    <span class="dashboard-eyebrow">Admin</span>
                    <h1>Se connecter</h1>
                    <p>Accès réservé à l’administration du site.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('admin.login.attempt') }}" method="post" class="admin-auth__form">
                    @csrf
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    <div>
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required autocomplete="current-password">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Rester connecté</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Connexion</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
