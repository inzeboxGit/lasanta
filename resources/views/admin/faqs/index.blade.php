@extends('admin.layout')

@section('title', 'FAQ')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1">FAQ</h1>
        <div class="text-muted">Gérez les questions fréquemment posées affichées sur la page d'accueil.</div>
    </div>
    <a href="{{ url('/') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la home</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

{{-- Section settings --}}
@if($faqSectionSetting)
<div class="admin-card p-4 mb-4">
    <h2 class="h5 mb-3">Paramètres de la section</h2>
    <form action="{{ route('admin.faqs.section-settings.update') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Sous-titre</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $faqSectionSetting->subtitle) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $faqSectionSetting->title) }}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Libellé bouton</label>
                <input type="text" name="button_label" class="form-control" value="{{ old('button_label', $faqSectionSetting->button_label) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Lien bouton</label>
                <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $faqSectionSetting->button_link) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Description <small class="text-muted">(texte sous le titre)</small></label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $faqSectionSetting->description) }}</textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Enregistrer les paramètres</button>
            </div>
        </div>
    </form>
</div>
@endif

{{-- List --}}
<div class="admin-card p-4 mb-4">
    <h2 class="h5 mb-3">Questions existantes</h2>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Ordre</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr class="{{ $editingFaq && $editingFaq->id === $faq->id ? 'table-primary' : '' }}">
                        <td>{{ $faq->id }}</td>
                        <td>{{ Str::limit($faq->question, 80) }}</td>
                        <td>{{ $faq->sort_order }}</td>
                        <td>
                            @if($faq->is_published)
                                <span class="badge bg-success">Publié</span>
                            @else
                                <span class="badge bg-secondary">Masqué</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.faqs.index', ['edit' => $faq->id]) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Supprimer cette FAQ ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Aucune FAQ. Créez-en une ci-dessous.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create / Edit form --}}
<div class="admin-card p-4">
    @if($editingFaq)
        <h2 class="h5 mb-3">Modifier la FAQ #{{ $editingFaq->id }}</h2>
        <form action="{{ route('admin.faqs.update', $editingFaq) }}" method="POST">
            @csrf @method('PUT')
    @else
        <h2 class="h5 mb-3">Nouvelle FAQ</h2>
        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
    @endif
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Question <span class="text-danger">*</span></label>
                <input type="text" name="question" class="form-control" value="{{ old('question', $editingFaq->question ?? '') }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">Réponse <span class="text-danger">*</span></label>
                <textarea name="answer" class="form-control" rows="5" required>{{ old('answer', $editingFaq->answer ?? '') }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ordre d'affichage</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $editingFaq->sort_order ?? 0) }}" min="0">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1"
                        {{ old('is_published', $editingFaq->is_published ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">Publié</label>
                </div>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{ $editingFaq ? 'Mettre à jour' : 'Créer la FAQ' }}</button>
                @if($editingFaq)
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Annuler</a>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection
