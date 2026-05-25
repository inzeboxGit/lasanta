@extends('admin.layout')

@section('title', 'Actualités')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Actualités</h1>
        <div class="text-muted">Gérer les articles</div>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Ajouter</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Paramètres de la page Actualités</h2>
        <a href="{{ route('news.index') }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Voir la page</a>
    </div>
    <form action="{{ route('admin.news.page-settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $headerSrc = media_url($newsPageSetting->header_image ?? null, 'img/hero_home_2.jpg');
        @endphp
        <div class="row g-6">
            <div class="col-md-7">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $newsPageSetting->subtitle ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $newsPageSetting->title ?? '') }}">
            </div>

            <!-- <div class="col-md-11">
                <label class="form-label">Texte hero.</label>
                <textarea name="hero_text" class="form-control" rows="4">{{ old('hero_text', $newsPageSetting->hero_text ?? '') }}</textarea>
            </div> -->
            <div class="col-md-7">
                <label class="form-label">Image header</label>
                <input type="file" name="header_image" id="news_header_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="news_header_preview" src="{{ $headerSrc }}" alt="" class="rounded" style="max-height:90px;">
                </div>
                @if(!empty($newsPageSetting->header_image ?? null) && !str_starts_with($newsPageSetting->header_image, 'img/'))
                    @include('admin.partials.remove-media-toggle', ['name' => 'remove_header_image', 'label' => 'Supprimer l’image header'])
                @endif
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>

<div class="admin-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Section Actualités — Accueil</h2>
        <small class="text-muted">Titre et sous-titre affichés sur la page d'accueil</small>
    </div>
    <form action="{{ route('admin.news.home-section.update') }}" method="post">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $newsSectionSetting->subtitle ?? 'Dernières nouvelles') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $newsSectionSetting->title ?? 'Actualités') }}">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </div>
        </div>
    </form>
</div>

<div class="admin-card p-3">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $item->title }}</div>
                            <div class="text-muted small">{{ $item->slug }}</div>
                        </td>
                        <td>{{ $item->published_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->status === 'published' ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Aperçu</a>
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="post" class="d-inline" onsubmit="return confirm('Supprimer cet article ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Aucun article</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $news->links('pagination::bootstrap-5') }}
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('news_header_image');
    const preview = document.getElementById('news_header_preview');

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
