@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Dashboard</h1>
        <div class="text-muted">Vue d'ensemble du site</div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="admin-card p-4 h-100">
            <div class="card-label">Chambres</div>
            <div class="card-value">{{ $roomsCount ?? 0 }}</div>
            <div class="text-muted">Total des chambres</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4 h-100">
            <div class="card-label">Actualités</div>
            <div class="card-value">{{ $newsCount ?? 0 }}</div>
            <div class="text-muted">Articles publiés</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4 h-100">
            <div class="card-label">Équipements</div>
            <div class="card-value">{{ $amenitiesCount ?? 0 }}</div>
            <div class="text-muted">Équipements disponibles</div>
        </div>
    </div>
</div>

<div class="admin-card p-3 mt-4">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <div class="fw-semibold">Dernières chambres</div>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.rooms.index') }}">Voir tout</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Prix / nuit</th>
                    <th>Statut</th>
                    <th>Créée</th>
                    <th>Dernière mise à jour</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestRooms ?? [] as $room)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $room->title }}</div>
                            <div class="text-muted small">{{ $room->slug }}</div>
                        </td>
                        <td>{{ $room->price_per_night ? number_format($room->price_per_night, 2) . ' €' : '-' }}</td>
                        <td>
                            <span class="badge {{ $room->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $room->status === 'published' ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td>{{ $room->created_at?->format('d/m/Y') }}</td>
                        <td>{{ $room->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucune chambre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
