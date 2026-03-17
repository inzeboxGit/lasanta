@extends('admin.layout')

@section('title', 'Restaurant')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Restaurant</h1>
        <div class="text-muted">Gerer la page Restaurant et ses elements affiches sur le front</div>
    </div>
    <a href="{{ route('admin.comodites.create') }}" class="btn btn-primary">Ajouter</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4 mb-4">
    <h2 class="h5 mb-3">Parametres de la page Restaurant</h2>
    <form action="{{ route('admin.comodites.section-settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $headerSrc = media_url($sectionSetting->header_image ?? null);
        @endphp
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Image header</label>
                <input type="file" name="header_image" id="restaurant_header_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="restaurant_header_preview" src="{{ $headerSrc ?? '' }}" alt="" class="rounded" style="max-height:120px;{{ empty($headerSrc) ? 'display:none;' : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $sectionSetting->subtitle ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $sectionSetting->title ?? '') }}">
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
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Ordre</th>
                    <th>Publiée</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comodites as $comodite)
                    <tr>
                        <td>
                            @php
                                $src = media_url($comodite->image_path);
                            @endphp
                            @if($src)
                                <img src="{{ $src }}" alt="{{ $comodite->title }}" style="width:56px;height:56px;object-fit:cover;border-radius:8px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $comodite->title }}</td>
                        <td>{{ $comodite->sort_order }}</td>
                        <td>{{ $comodite->is_published ? 'Oui' : 'Non' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.comodites.edit', $comodite) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.comodites.destroy', $comodite) }}" method="post" class="d-inline" onsubmit="return confirm('Supprimer cette commodité ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucun element restaurant</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $comodites->links() }}
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('restaurant_header_image');
    const preview = document.getElementById('restaurant_header_preview');

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
