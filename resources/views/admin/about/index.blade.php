@extends('admin.layout')

@section('title', 'À propos')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Section À propos</h1>
        <div class="text-muted">Gérer le contenu affiché sur l'accueil et la page À propos</div>
    </div>
    <a href="{{ route('about.index') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la page</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4">
    <form action="{{ route('admin.about.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $mainSrc = null;
            if (!empty($aboutSetting->main_image ?? null)) {
                $mainSrc = str_starts_with($aboutSetting->main_image, 'img/')
                    ? asset($aboutSetting->main_image)
                    : asset('storage/' . $aboutSetting->main_image);
            }

            $overlaySrc = null;
            if (!empty($aboutSetting->overlay_image ?? null)) {
                $overlaySrc = str_starts_with($aboutSetting->overlay_image, 'img/')
                    ? asset($aboutSetting->overlay_image)
                    : asset('storage/' . $aboutSetting->overlay_image);
            }
        @endphp

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Petit titre</label>
                <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $aboutSetting->small_title ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $aboutSetting->title ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Lead</label>
                <input type="text" name="lead" class="form-control" value="{{ old('lead', $aboutSetting->lead ?? '') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $aboutSetting->description ?? '') }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Signature</label>
                <input type="text" name="signature" class="form-control" value="{{ old('signature', $aboutSetting->signature ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Image principale</label>
                <input type="file" name="main_image" id="about_main_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="about_main_preview" src="{{ $mainSrc ?? '' }}" alt="" class="rounded" style="max-height:100px;{{ empty($mainSrc) ? 'display:none;' : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Image superposée</label>
                <input type="file" name="overlay_image" id="about_overlay_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="about_overlay_preview" src="{{ $overlaySrc ?? '' }}" alt="" class="rounded" style="max-height:100px;{{ empty($overlaySrc) ? 'display:none;' : '' }}">
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bindPreview = (inputId, previewId) => {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
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
    };

    bindPreview('about_main_image', 'about_main_preview');
    bindPreview('about_overlay_image', 'about_overlay_preview');
});
</script>
@endsection
