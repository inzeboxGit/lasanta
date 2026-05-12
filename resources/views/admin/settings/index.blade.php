@extends('admin.layout')

@section('title', 'Paramètres')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Paramètres du site</h1>
        <div class="text-muted">Téléphones, email, adresse, nom du site et réseaux sociaux</div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Paramètres de la page Contact</h2>
        <a href="{{ url('/contacts') }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Voir la page</a>
    </div>
    <form action="{{ route('admin.contact.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $contactHeaderSrc = media_url($contactPageSetting->header_image ?? null, 'img/hero_home_2.jpg');
        @endphp
        <div class="row g-3">
            <div class="col-12">
                <h3 class="h6 mb-1">En-tête de la page Contact</h3>
                <p class="text-muted mb-0">Textes et image du hero de la page contact.</p>
            </div>
            <div class="col-12">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $contactPageSetting->subtitle ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $contactPageSetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Titre disponibilité</label>
                <input type="text" name="availability_title" class="form-control" value="{{ old('availability_title', $contactPageSetting->availability_title ?? '') }}">
            </div>
            <div class="col-12">
                <hr class="my-2">
                <h3 class="h6 mb-1">Carte</h3>
                <p class="text-muted mb-0">Coordonnées utilisées pour la position de la carte.</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Latitude GPS</label>
                <input type="number" step="0.0000001" name="map_latitude" class="form-control" value="{{ old('map_latitude', $contactPageSetting->map_latitude ?? '42.6043096') }}" placeholder="42.6043096">
            </div>
            <div class="col-md-6">
                <label class="form-label">Longitude GPS</label>
                <input type="number" step="0.0000001" name="map_longitude" class="form-control" value="{{ old('map_longitude', $contactPageSetting->map_longitude ?? '8.9295210') }}" placeholder="8.9295210">
            </div>
            <div class="col-12">
                <label class="form-label">Image header</label>
                <input type="file" name="header_image" id="contact_header_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="contact_header_preview" src="{{ $contactHeaderSrc }}" alt="" class="rounded" style="max-height:90px;">
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>

<div class="admin-card p-4 mt-4" id="site-settings">
    <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $footerBackgroundSrc = media_url($siteSetting->footer_background_image ?? null, 'img/rooms/3.jpg');
        @endphp
        <div class="row g-3">
            <div class="col-12">
                <h2 class="h6 mb-1">Informations générales</h2>
                <p class="text-muted mb-0">Nom du site, langue.</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nom du site</label>
                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $siteSetting->site_name ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $siteSetting->email ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Langue par défaut du site</label>
                <select name="default_locale" class="form-select">
                    @foreach(($locales ?? ['fr' => 'Français']) as $localeKey => $localeLabel)
                        <option value="{{ $localeKey }}" {{ old('default_locale', $siteSetting->default_locale ?? config('app.locale', 'fr')) === $localeKey ? 'selected' : '' }}>
                            {{ $localeLabel }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <hr class="my-2">
                <h2 class="h6 mb-1">Contact et destinataire</h2>
                <p class="text-muted mb-0">Adresse email utilisée pour recevoir les formulaires.</p>
            </div>
            <div class="col-12">
                <div class="form-check mt-2">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value="1"
                        id="use_site_email_for_contact"
                        name="use_site_email_for_contact"
                        {{ old('use_site_email_for_contact', $siteSetting->use_site_email_for_contact ?? true) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="use_site_email_for_contact">
                        Utiliser l'email du site comme destinataire des formulaires de contact
                    </label>
                </div>
            </div>
            <div class="col-md-6" id="contact_recipient_email_wrap">
                <label class="form-label">Email destinataire des contacts</label>
                <input
                    type="email"
                    name="contact_recipient_email"
                    class="form-control"
                    value="{{ old('contact_recipient_email', $siteSetting->contact_recipient_email ?? '') }}"
                    placeholder="contact@example.com"
                >
                <div class="form-text">Utilisé seulement si la case ci-dessus est décochée.</div>
            </div>
            <div class="col-12">
                <hr class="my-2">
                <h2 class="h6 mb-1">Coordonnées du site</h2>
                <p class="text-muted mb-0">Téléphones et adresse affichés sur le site.</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Téléphone 1</label>
                <input type="text" name="phone_primary" class="form-control" value="{{ old('phone_primary', $siteSetting->phone_primary ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Téléphone 2</label>
                <input type="text" name="phone_secondary" class="form-control" value="{{ old('phone_secondary', $siteSetting->phone_secondary ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Adresse</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $siteSetting->address ?? '') }}">
            </div>
            <div class="col-12">
                <hr class="my-2">
                <h2 class="h6 mb-1">Réseaux sociaux</h2>
                <p class="text-muted mb-0">Liens externes affichés dans le front.</p>
            </div>
            <div class="col-md-6">
                <label class="form-label">Facebook</label>
                <input type="text" name="facebook_url" class="form-control" value="{{ old('facebook_url', $siteSetting->facebook_url ?? '') }}" placeholder="https://facebook.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label">Instagram</label>
                <input type="text" name="instagram_url" class="form-control" value="{{ old('instagram_url', $siteSetting->instagram_url ?? '') }}" placeholder="https://instagram.com/...">
            </div>
            <!-- <div class="col-md-6">
                <label class="form-label">WhatsApp</label>
                <input type="text" name="whatsapp_url" class="form-control" value="{{ old('whatsapp_url', $siteSetting->whatsapp_url ?? '') }}" placeholder="https://wa.me/...">
            </div> -->
            <div class="col-md-6">
                <label class="form-label">Twitter / X</label>
                <input type="text" name="twitter_url" class="form-control" value="{{ old('twitter_url', $siteSetting->twitter_url ?? '') }}" placeholder="https://x.com/...">
            </div>
            <div class="col-12">
                <hr class="my-2">
                <h2 class="h6 mb-1">Scripts globaux</h2>
                <p class="text-muted mb-0">Code injecté dans le head de toutes les pages.</p>
            </div>
            <div class="col-12">
                <label class="form-label">Scripts personnalisés (Head)</label>
                <textarea name="custom_head_scripts" class="form-control" rows="5" placeholder="&lt;script&gt;...&lt;/script&gt;">{{ old('custom_head_scripts', $siteSetting->custom_head_scripts ?? '') }}</textarea>
                <div class="form-text">Ces scripts seront ajoutés dans la balise &lt;head&gt; de toutes les pages (Google Analytics, Facebook Pixel, etc.).</div>
            </div>
            <!-- @if($supportsFooterBackgroundImage ?? false)
                <div class="col-12">
                    <label class="form-label">Image de fond du footer</label>
                    <input type="file" name="footer_background_image" id="footer_background_image" class="form-control" accept="image/*">
                    <div class="form-text">Image affichée derrière le footer. Taille max 5 Mo.</div>
                    <div class="mt-2">
                        <img id="footer_background_image_preview" src="{{ $footerBackgroundSrc }}" alt="" class="rounded" style="max-height:120px;">
                    </div>
                </div>
            @endif -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('use_site_email_for_contact');
    const wrap = document.getElementById('contact_recipient_email_wrap');
    const footerBackgroundInput = document.getElementById('footer_background_image');
    const footerBackgroundPreview = document.getElementById('footer_background_image_preview');
    const contactHeaderInput = document.getElementById('contact_header_image');
    const contactHeaderPreview = document.getElementById('contact_header_preview');

    if (checkbox && wrap) {
        const syncVisibility = function () {
            wrap.style.display = checkbox.checked ? 'none' : '';
        };

        checkbox.addEventListener('change', syncVisibility);
        syncVisibility();
    }

    if (footerBackgroundInput && footerBackgroundPreview) {
        footerBackgroundInput.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                footerBackgroundPreview.src = e.target.result;
                footerBackgroundPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    if (contactHeaderInput && contactHeaderPreview) {
        contactHeaderInput.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                contactHeaderPreview.src = e.target.result;
                contactHeaderPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endsection
