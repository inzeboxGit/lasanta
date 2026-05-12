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

@endsection
