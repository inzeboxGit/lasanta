@extends('admin.layout')

@section('title', 'Hero accueil')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Hero accueil</h1>
        <div class="text-muted">Gerer le titre, l'image de fond et l'affichage du formulaire sur la homepage</div>
    </div>
    <a href="{{ url('/') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la home</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4">
    <form action="{{ route('admin.hero.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $backgroundSrc = null;
            if (!empty($heroSetting->background_image ?? null)) {
                $backgroundSrc = str_starts_with($heroSetting->background_image, 'img/')
                    ? asset($heroSetting->background_image)
                    : asset('storage/' . $heroSetting->background_image);
            }
        @endphp

        <div class="row g-3">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="hero_show_booking_form" name="show_booking_form" value="1" {{ old('show_booking_form', $heroSetting->show_booking_form ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="hero_show_booking_form">Afficher le formulaire de recherche</label>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Petit titre</label>
                <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $heroSetting->small_title ?? '') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $heroSetting->title ?? '') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Lien du bouton Reserver</label>
                <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $heroSetting->button_link ?? '') }}" placeholder="https://... ou /appartements">
            </div>
            <div class="col-md-4">
                <label class="form-label">Target du bouton</label>
                <select name="button_target" class="form-select">
                    <option value="_self" {{ old('button_target', $heroSetting->button_target ?? '_self') === '_self' ? 'selected' : '' }}>Meme onglet</option>
                    <option value="_blank" {{ old('button_target', $heroSetting->button_target ?? '_self') === '_blank' ? 'selected' : '' }}>Nouvel onglet</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Image d'arriere-plan</label>
                <input type="file" name="background_image" id="hero_background_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="hero_background_preview" src="{{ $backgroundSrc ?? '' }}" alt="" class="rounded" style="max-height:120px;{{ empty($backgroundSrc) ? 'display:none;' : '' }}">
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
    const input = document.getElementById('hero_background_image');
    const preview = document.getElementById('hero_background_preview');

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
