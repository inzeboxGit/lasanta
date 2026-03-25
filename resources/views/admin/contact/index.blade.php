@extends('admin.layout')

@section('title', 'Contact')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Contact</h1>
        <div class="text-muted">Gérer l'en-tête de la page contact</div>
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
