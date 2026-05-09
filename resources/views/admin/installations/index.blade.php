@extends('admin.layout')

@section('title', 'Installations')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Installations principales</h1>
        <div class="text-muted">Gérer la section installations de la page d'accueil</div>
    </div>
    <a href="{{ route('admin.installations.create') }}" class="btn btn-primary">Ajouter</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-4 mb-4">
    <h2 class="h5 mb-3">Paramètres de section Installations</h2>
    <form action="{{ route('admin.installations.section-settings.update') }}" method="post">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $sectionSetting->subtitle ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $sectionSetting->title ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $sectionSetting->description ?? '') }}</textarea>
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
                    <th>Icône</th>
                    <th>Titre</th>
                    <th>Ordre</th>
                    <th>Publiée</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($installations as $installation)
                    <tr>
                        <td>
                            @if($installation->image_path)
                                <img src="{{ asset('storage/' . $installation->image_path) }}" alt="{{ $installation->title }}" style="width:56px;height:56px;object-fit:cover;border-radius:8px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($installation->icon)
                                <span class="d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px;border-radius:8px;background:#f1f3f5;">
                                    <i class="{{ $installation->icon }}"></i>
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $installation->title }}</td>
                        <td>{{ $installation->sort_order }}</td>
                        <td>
                            @if($installation->is_published)
                                <span class="badge bg-success">Oui</span>
                            @else
                                <span class="badge bg-secondary">Non</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.installations.edit', $installation) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.installations.destroy', $installation) }}" method="post" class="d-inline" onsubmit="return confirm('Supprimer cette installation ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
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

<div class="mt-3">
    {{ $installations->links('pagination::bootstrap-5') }}
</div>
@endsection
