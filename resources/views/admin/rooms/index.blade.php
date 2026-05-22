@extends('admin.layout')

@section('title', 'Chambres')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Chambres</h1>
        <div class="text-muted">Gérer les chambres</div>
    </div>
    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Ajouter une chambre</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Paramètres page Chambres</h2>
        <a href="{{ route('appartements.index') }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Voir la page</a>
    </div>
    <form action="{{ route('admin.rooms.page-settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $headerSrc = null;
            if (!empty($appartmentPageSetting->header_image ?? null)) {
                $headerSrc = str_starts_with($appartmentPageSetting->header_image, 'img/')
                    ? asset($appartmentPageSetting->header_image)
                    : asset('storage/' . $appartmentPageSetting->header_image);
            }
        @endphp
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Petit Titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $appartmentPageSetting->subtitle ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $appartmentPageSetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Description de la section Chambres Accueil (facultatif)</label>
                <textarea name="home_description" class="form-control" rows="4">{{ old('home_description', $appartmentPageSetting->home_description ?? '') }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Image header</label>
                <input type="file" name="header_image" id="appartement_header_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="appartement_header_preview" src="{{ $headerSrc ?? '' }}" alt="" class="rounded" style="max-height:90px;{{ empty($headerSrc) ? 'display:none;' : '' }}">
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>

<div class="admin-card p-3">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Ordre</th>
                    <th>Titre</th>
                    <th>Superficie</th>
                    <th>Prix / nuit</th>
                    <th>Statut</th>
                    <th>Créée</th>
                    <th>Dernière mise à jour</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                    <tr>
                        <td>{{ $room->sort_order ?? 0 }}</td>
                        <td>
                            <div class="fw-semibold">{{ $room->title }}</div>
                            <div class="text-muted small">{{ $room->slug }}</div>
                        </td>
                        <td>{{ $room->external_id ?: '-' }}</td>
                        <td>{{ $room->price_per_night ? number_format($room->price_per_night, 2) . ' €' : '-' }}</td>
                        <td>
                            <span class="badge {{ $room->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $room->status === 'published' ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td>{{ $room->created_at->format('d/m/Y') }}</td>
                        <td>{{ $room->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('appartements.index') }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Aperçu</a>
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="post" class="d-inline" onsubmit="return confirm('Supprimer cette chambre ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Aucune chambre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $rooms->links('pagination::bootstrap-5') }}
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('appartement_header_image');
    const preview = document.getElementById('appartement_header_preview');

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
