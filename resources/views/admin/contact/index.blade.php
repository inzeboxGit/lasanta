@extends('admin.layout')

@section('title', 'Contact')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Contact</h1>
        <div class="text-muted">Gérer l'en-tête et la section disponibilité de la page contact</div>
    </div>
    <a href="{{ url('/contacts') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la page</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4">
    <h2 class="h5 mb-3">Paramètres de la page Contact</h2>
    <form action="{{ route('admin.contact.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $headerSrc = media_url($contactPageSetting->header_image ?? null, 'img/hero_home_2.jpg');
        @endphp
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $contactPageSetting->subtitle ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $contactPageSetting->title ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Petit titre disponibilité</label>
                <input type="text" name="availability_small" class="form-control" value="{{ old('availability_small', $contactPageSetting->availability_small ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Titre disponibilité</label>
                <input type="text" name="availability_title" class="form-control" value="{{ old('availability_title', $contactPageSetting->availability_title ?? '') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Texte disponibilité</label>
                <textarea name="availability_text" class="form-control" rows="3">{{ old('availability_text', $contactPageSetting->availability_text ?? '') }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label d-block mb-2">Libellés réservation et calendrier</label>
                <ul class="nav nav-tabs" id="contact-booking-labels-tabs" role="tablist">
                    @foreach($locales as $localeKey => $localeLabel)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="contact-booking-labels-{{ $localeKey }}-tab" data-bs-toggle="tab" data-bs-target="#contact-booking-labels-{{ $localeKey }}" type="button" role="tab" aria-controls="contact-booking-labels-{{ $localeKey }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $localeLabel }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content border border-top-0 rounded-bottom p-3">
                    @foreach($locales as $localeKey => $localeLabel)
                        @php
                            $isFrench = $localeKey === 'fr';
                            $valueFor = function (string $field) use ($contactPageSetting, $localeKey, $isFrench) {
                                if ($isFrench) {
                                    return old($field, $contactPageSetting->{$field} ?? '');
                                }

                                $translatedValue = '';
                                if (method_exists($contactPageSetting, 'translations') && $contactPageSetting->relationLoaded('translations')) {
                                    $translatedValue = $contactPageSetting->translations
                                        ->first(fn ($item) => $item->locale === $localeKey && $item->field === $field)?->value ?? '';
                                }

                                return old('translations.' . $localeKey . '.' . $field, $translatedValue);
                            };
                        @endphp
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="contact-booking-labels-{{ $localeKey }}" role="tabpanel" aria-labelledby="contact-booking-labels-{{ $localeKey }}-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Infos et réservations</label>
                                    <input type="text" name="{{ $isFrench ? 'info_booking_label' : 'translations[' . $localeKey . '][info_booking_label]' }}" class="form-control" value="{{ $valueFor('info_booking_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sélectionner un appartement</label>
                                    <input type="text" name="{{ $isFrench ? 'select_room_label' : 'translations[' . $localeKey . '][select_room_label]' }}" class="form-control" value="{{ $valueFor('select_room_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Adultes</label>
                                    <input type="text" name="{{ $isFrench ? 'adults_label' : 'translations[' . $localeKey . '][adults_label]' }}" class="form-control" value="{{ $valueFor('adults_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Enfants</label>
                                    <input type="text" name="{{ $isFrench ? 'children_label' : 'translations[' . $localeKey . '][children_label]' }}" class="form-control" value="{{ $valueFor('children_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Réserver maintenant</label>
                                    <input type="text" name="{{ $isFrench ? 'book_now_label' : 'translations[' . $localeKey . '][book_now_label]' }}" class="form-control" value="{{ $valueFor('book_now_label') }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-text">Les jours, mois et textes internes du calendrier suivent automatiquement la langue active du site. Les champs ci-dessus pilotent les autres textes visibles de la réservation.</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Latitude GPS</label>
                <input type="number" step="0.0000001" name="map_latitude" class="form-control" value="{{ old('map_latitude', $contactPageSetting->map_latitude ?? '42.6043096') }}" placeholder="42.6043096">
            </div>
            <div class="col-md-4">
                <label class="form-label">Longitude GPS</label>
                <input type="number" step="0.0000001" name="map_longitude" class="form-control" value="{{ old('map_longitude', $contactPageSetting->map_longitude ?? '8.9295210') }}" placeholder="8.9295210">
            </div>
            <div class="col-md-4">
                <label class="form-label">Image header</label>
                <input type="file" name="header_image" id="contact_header_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="contact_header_preview" src="{{ $headerSrc }}" alt="" class="rounded" style="max-height:90px;">
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('contact_header_image');
    const preview = document.getElementById('contact_header_preview');

    if (!input || !preview) return;

    input.addEventListener('change', function (event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
