@extends('admin.layout')

@section('title', 'Hero accueil')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Hero accueil</h1>
        <div class="text-muted">Gerer le titre, le type de fond (video ou image) et l'affichage du formulaire sur la homepage</div>
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
            $backgroundType = old('background_type', $heroSetting->background_type ?? 'video');
            $backgroundVideo = old('background_video', $heroSetting->background_video ?? 'video/sunset.mp4');
            $backgroundVideoSrc = str_starts_with($backgroundVideo, 'video/')
                ? asset($backgroundVideo)
                : asset('storage/' . $backgroundVideo);
            $youtubeVideoUrl = old('youtube_video_url', $heroSetting->youtube_video_url ?? '');
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
                <label class="form-label d-block">Type d'arriere-plan</label>
                <div class="d-flex flex-wrap gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="background_type" id="hero_background_type_video" value="video" {{ $backgroundType === 'video' ? 'checked' : '' }}>
                        <label class="form-check-label" for="hero_background_type_video">Video</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="background_type" id="hero_background_type_image" value="image" {{ $backgroundType === 'image' ? 'checked' : '' }}>
                        <label class="form-check-label" for="hero_background_type_image">Image</label>
                    </div>
                </div>
                <div class="form-text">Si aucun lien YouTube ni upload n'est defini, la video par defaut reste `public/video/sunset.mp4`.</div>
            </div>
            <div class="col-12" id="hero_background_video_fields">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Upload video</label>
                        <input type="file" name="background_video" id="hero_background_video" class="form-control" accept="video/mp4,video/webm,video/ogg,video/quicktime">
                        <div class="form-text">Formats acceptes: mp4, webm, ogg, mov. Taille max 50 Mo.</div>
                        <div class="mt-2">
                            <video id="hero_background_video_preview" src="{{ $backgroundVideoSrc }}" class="rounded w-100" style="max-height:220px; object-fit:cover;" controls muted playsinline></video>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lien YouTube</label>
                        <input type="url" name="youtube_video_url" class="form-control" value="{{ $youtubeVideoUrl }}" placeholder="https://www.youtube.com/watch?v=...">
                        <div class="form-text">Si ce champ est rempli, le lien YouTube est prioritaire sur la video uploadée.</div>
                    </div>
                </div>
            </div>
            <div class="col-12" id="hero_background_image_field">
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
    const typeInputs = document.querySelectorAll('input[name="background_type"]');
    const videoFields = document.getElementById('hero_background_video_fields');
    const imageField = document.getElementById('hero_background_image_field');
    const videoInput = document.getElementById('hero_background_video');
    const videoPreview = document.getElementById('hero_background_video_preview');
    const input = document.getElementById('hero_background_image');
    const preview = document.getElementById('hero_background_preview');

    function toggleImageField() {
        const selectedType = document.querySelector('input[name="background_type"]:checked')?.value ?? 'video';
        if (videoFields) {
            videoFields.style.display = selectedType === 'video' ? 'block' : 'none';
        }
        if (imageField) {
            imageField.style.display = selectedType === 'image' ? 'block' : 'none';
        }
    }

    typeInputs.forEach(function (typeInput) {
        typeInput.addEventListener('change', toggleImageField);
    });

    toggleImageField();

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

    if (!videoInput || !videoPreview) {
        return;
    }

    videoInput.addEventListener('change', function (event) {
        const file = event.target.files && event.target.files[0];
        if (!file) {
            return;
        }

        videoPreview.src = URL.createObjectURL(file);
        videoPreview.style.display = 'block';
    });
});
</script>
@endsection
