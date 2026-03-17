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
    {{ $news->links() }}
</div>
@endsection
