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
    {{ $testimonials->links() }}
</div>
@endsection
