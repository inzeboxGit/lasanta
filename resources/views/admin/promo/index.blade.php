@extends('admin.layout')

@section('title', 'Promo')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Section promo</h1>
        <div class="text-muted">Gerer le modal promotionnel affiche sur la page d'accueil</div>
    </div>
    <a href="{{ url('/') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la home</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4">
    <form action="{{ route('admin.promo.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $imageSrc = null;
            if (!empty($promoSetting->image ?? null)) {
                $imageSrc = str_starts_with($promoSetting->image, 'img/')
                    ? asset($promoSetting->image)
                    : asset('storage/' . $promoSetting->image);
            }
        @endphp

        <div class="row g-3">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="promo_enabled" name="is_enabled" value="1" {{ old('is_enabled', $promoSetting->is_enabled ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="promo_enabled">Afficher le modal promo sur la home</label>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $promoSetting->subtitle ?? '') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $promoSetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Texte</label>
                <textarea name="text" class="form-control" rows="5">{{ old('text', $promoSetting->text ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Date de debut</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', !empty($promoSetting->start_date) ? \Illuminate\Support\Carbon::parse($promoSetting->start_date)->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Date de fin</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', !empty($promoSetting->end_date) ? \Illuminate\Support\Carbon::parse($promoSetting->end_date)->format('Y-m-d') : '') }}">
                <div class="form-text">Laissez vide pour afficher sans limite de date.</div>
            </div>
            <div class="col-md-8">
                <label class="form-label">Lien du bouton</label>
                <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $promoSetting->button_link ?? '') }}" placeholder="https://... ou /appartements">
            </div>
            <div class="col-md-4">
                <label class="form-label">Image</label>
                <input type="file" name="image" id="promo_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="promo_image_preview" src="{{ $imageSrc ?? '' }}" alt="" class="rounded" style="max-height:100px;{{ empty($imageSrc) ? 'display:none;' : '' }}">
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('promo_image');
    const preview = document.getElementById('promo_image_preview');

    if (!input || !preview) {
        return;
    }

    input.addEventListener('change', function (event) {
        const file = event.target.files && event.target.files[0];
        if (!file) {
            return;
        }

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
