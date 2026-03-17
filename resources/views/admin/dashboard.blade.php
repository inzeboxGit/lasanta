@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
@php
    $latestRoomsCollection = collect($latestRooms ?? []);
    $lastUpdatedRoom = $latestRoomsCollection->sortByDesc('updated_at')->first();
    $statCards = [
        [
            'label' => 'Chambres',
            'value' => $roomsCount ?? 0,
            'note' => 'Inventaire disponible',
            'accent' => 'sun',
            'icon' => 'bi-door-open',
        ],
        [
            'label' => 'Actualités',
            'value' => $newsCount ?? 0,
            'note' => 'Contenus publiés',
            'accent' => 'sea',
            'icon' => 'bi-megaphone',
        ],
        [
            'label' => 'Équipements',
            'value' => $amenitiesCount ?? 0,
            'note' => 'Services configurés',
            'accent' => 'sand',
            'icon' => 'bi-stars',
        ],
    ];

    $quickLinks = [
        ['label' => 'Gérer les chambres', 'route' => route('admin.rooms.index')],
        ['label' => 'Modifier le hero', 'route' => route('admin.hero.index')],
        ['label' => 'Voir le restaurant', 'route' => route('admin.comodites.index')],
        ['label' => 'Publier une actualité', 'route' => route('admin.news.index')],
    ];
@endphp

<div class="dashboard-shell">
    <section class="dashboard-hero admin-card">
        <div class="dashboard-hero__copy">
            <span class="dashboard-eyebrow">Administration</span>
            <h1>Tableau de bord</h1>
            <p>Une vue d'ensemble claire du contenu Residence Bella Vista, avec les accès rapides aux sections qui bougent le plus.</p>
        </div>
        <div class="dashboard-hero__meta">
            <div class="dashboard-meta-card">
                <span class="dashboard-meta-card__label">Derniere activite</span>
                <strong>{{ $lastUpdatedRoom?->title ?? 'Aucune chambre recente' }}</strong>
                <span>{{ $lastUpdatedRoom?->updated_at?->format('d/m/Y H:i') ?? 'Pas encore de mise a jour' }}</span>
            </div>
            <div class="dashboard-meta-card">
                <span class="dashboard-meta-card__label">Aujourd'hui</span>
                <strong>{{ now()->format('d/m/Y') }}</strong>
                <span>{{ now()->format('H:i') }}</span>
            </div>
        </div>
    </section>

    <section class="row g-4 mt-1">
        @foreach($statCards as $card)
            <div class="col-xl-4 col-md-6">
                <div class="admin-card dashboard-stat dashboard-stat--{{ $card['accent'] }}">
                    <div class="dashboard-stat__icon">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>
                    <div class="dashboard-stat__content">
                        <span class="dashboard-stat__label">{{ $card['label'] }}</span>
                        <strong class="dashboard-stat__value">{{ $card['value'] }}</strong>
                        <span class="dashboard-stat__note">{{ $card['note'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    <section class="row g-4 mt-1">
        <div class="col-xl-4">
            <div class="admin-card dashboard-panel h-100">
                <div class="dashboard-panel__head">
                    <div>
                        <span class="dashboard-panel__eyebrow">Raccourcis</span>
                        <h2>Acces rapides</h2>
                    </div>
                </div>
                <div class="dashboard-quicklinks">
                    @foreach($quickLinks as $link)
                        <a href="{{ $link['route'] }}" class="dashboard-quicklink">
                            <span>{{ $link['label'] }}</span>
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="admin-card dashboard-panel h-100">
                <div class="dashboard-panel__head">
                    <div>
                        <span class="dashboard-panel__eyebrow">Contenu recent</span>
                        <h2>Dernieres chambres</h2>
                    </div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.rooms.index') }}">Voir tout</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 dashboard-table">
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
                            @forelse($latestRoomsCollection as $room)
                                <tr>
                                    <td>
                                        <div class="dashboard-room">
                                            <span class="dashboard-room__dot"></span>
                                            <div>
                                                <div class="fw-semibold">{{ $room->title }}</div>
                                                <div class="text-muted small">{{ $room->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $room->price_per_night ? number_format($room->price_per_night, 2) . ' €' : '-' }}</td>
                                    <td>
                                        <span class="dashboard-status dashboard-status--{{ $room->status === 'published' ? 'published' : 'draft' }}">
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
                                    <td colspan="6" class="text-center text-muted py-4">Aucune chambre</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
