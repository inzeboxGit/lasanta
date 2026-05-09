@extends('admin.layout')

@section('title', 'Équipements')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Équipements</h1>
        <div class="text-muted">Liste séparée: équipements chambres et installations homepage</div>
    </div>
    <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary">Ajouter</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-3">
    <h2 class="h5 mb-3">Équipements chambres</h2>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Icône</th>
                    <th>Titre</th>
                    <th>Portée</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($amenities as $amenity)
                    <tr>
                        <td>
                            @if($amenity->icon)
                                <span class="d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px;border-radius:8px;background:#f1f3f5;">
                                    <i class="{{ $amenity->icon }}"></i>
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $amenity->title }}</td>
                        <td>
                            @if($amenity->scope === 'both')
                                <span class="badge bg-info text-dark">Both</span>
                            @else
                                <span class="badge bg-secondary">Room</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.amenities.edit', $amenity) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.amenities.destroy', $amenity) }}" method="post" class="d-inline" onsubmit="return confirm('Supprimer cet équipement ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Aucun équipement</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $amenities->links('pagination::bootstrap-5') }}
</div>

{{-- Section: Contenu principal page Activités --}}
<div class="admin-card p-3 mt-4">
    <h2 class="h5 mb-3">Contenu principal <span class="text-muted fw-normal" style="font-size:.85em">(section "À propos" — page Activités)</span></h2>
    <form action="{{ route('admin.amenities.activites-about.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $activitesAboutSetting->small_title ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $activitesAboutSetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Description <small class="text-muted">(séparer les paragraphes par une ligne vide)</small></label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $activitesAboutSetting->description ?? '') }}</textarea>
            </div>
            @foreach([['main_image', 'Image 1'], ['overlay_image', 'Image 2'], ['third_image', 'Image 3']] as [$field, $label])
            <div class="col-md-4">
                <label class="form-label">{{ $label }}</label>
                <input type="file" name="{{ $field }}" class="form-control" accept="image/*">
                @if(!empty($activitesAboutSetting->$field))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $activitesAboutSetting->$field) }}" alt="" style="max-height:80px;" class="rounded">
                    </div>
                @endif
            </div>
            @endforeach
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </form>
</div>

{{-- Section: Galerie page Activités --}}
<div class="admin-card p-3 mt-4">
    <h2 class="h5 mb-3">Galerie <span class="text-muted fw-normal" style="font-size:.85em">(page Activités — images viennent des installations)</span></h2>
    <form action="{{ route('admin.amenities.activites-gallery.update') }}" method="post">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $activitesGallerySetting->small_title ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $activitesGallerySetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <p class="text-muted mb-0"><small>Les images de la galerie proviennent des <strong>installations</strong> (scope home/both) qui ont une image définie. Gérez-les via <a href="{{ route('admin.installations.index') }}">les installations</a>.</small></p>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </form>
</div>

<div class="admin-card p-3 mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Informations pratiques <span class="text-muted fw-normal" style="font-size:.85em">(page Activités)</span></h2>
        <a href="{{ route('admin.installations.index') }}" class="btn btn-sm btn-outline-primary">Gérer installations</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Icône</th>
                    <th>Titre</th>
                    <th>Ordre</th>
                    <th>Publiée</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($installations as $installation)
                    <tr>
                        <td>
                            @if($installation->image_path)
                                <img src="{{ asset('storage/' . $installation->image_path) }}" alt="{{ $installation->title }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($installation->icon)
                                <i class="{{ $installation->icon }}"></i>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $installation->title }}</td>
                        <td>{{ $installation->sort_order }}</td>
                        <td>{{ $installation->is_published ? 'Oui' : 'Non' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.installations.edit', $installation) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucune installation</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
