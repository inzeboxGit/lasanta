@extends('admin.layout')

@section('title', 'Témoignages')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Témoignages</h1>
        <div class="text-muted">Gérer les témoignages de la page d'accueil</div>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">Ajouter</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Fond de la section témoignages</h2>
        <a href="{{ url('/') }}#testimonials" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Voir la section</a>
    </div>
    <form action="{{ route('admin.testimonials.section-settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @php
            $backgroundSrc = media_url($testimonialSectionSetting->header_image ?? null, 'img/hero_home_1.jpg');
        @endphp
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $testimonialSectionSetting->subtitle ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $testimonialSectionSetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Image d'arrière-plan</label>
                <input type="file" name="header_image" id="testimonials_background_image" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img id="testimonials_background_preview" src="{{ $backgroundSrc }}" alt="" class="rounded" style="max-height:120px;">
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
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Ordre</th>
                    <th>Publiée</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                    @php
                        $photoSrc = null;
                        if (!empty($testimonial->photo_path)) {
                            $photoSrc = str_starts_with($testimonial->photo_path, 'img/')
                                ? asset($testimonial->photo_path)
                                : asset('storage/' . $testimonial->photo_path);
                        }
                    @endphp
                    <tr>
                        <td>
                            @if($photoSrc)
                                <img src="{{ $photoSrc }}" alt="{{ $testimonial->name }}" style="width:48px;height:48px;object-fit:cover;border-radius:50%;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $testimonial->name }}</td>
                        <td>{{ $testimonial->published_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $testimonial->sort_order }}</td>
                        <td>{{ $testimonial->is_published ? 'Oui' : 'Non' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce témoignage ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucun témoignage</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $testimonials->links('pagination::bootstrap-5') }}
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('testimonials_background_image');
    const preview = document.getElementById('testimonials_background_preview');

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
