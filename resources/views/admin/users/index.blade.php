@extends('admin.layout')

@section('title', 'Utilisateurs')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">Utilisateurs</h1>
        <div class="text-muted">Créer des accès admin, modifier les mots de passe et désactiver un compte sans le supprimer.</div>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Ajouter</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-card p-3">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Créé le</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                            @if(auth()->id() === $user->id)
                                <span class="badge bg-light text-dark border ms-2">Vous</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Désactivé</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucun utilisateur</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endsection
