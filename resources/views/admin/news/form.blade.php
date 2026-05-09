@php
    $item = $item ?? null;
    $isEdit = isset($item);
@endphp

<div class="admin-card p-4">
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $item->title ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $item->slug ?? '') }}" placeholder="auto">
        </div>
        <div class="col-md-6">
            <label class="form-label">Auteur</label>
            <input type="text" name="author" class="form-control" value="{{ old('author', $item->author ?? '') }}" placeholder="Admin">
        </div>
        <div class="col-md-6">
            <label class="form-label">Catégorie</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $item->category ?? '') }}" placeholder="Ex: Événement, Offre...">
        </div>
        <div class="col-md-3">
            <label class="form-label">Date</label>
            <input type="date" name="published_at" class="form-control" value="{{ old('published_at', optional($item?->published_at)->format('Y-m-d')) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Statut</label>
            <select name="status" class="form-select">
                <option value="draft" {{ old('status', $item->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                <option value="published" {{ old('status', $item->status ?? 'draft') === 'published' ? 'selected' : '' }}>Publié</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Résumé</label>
            <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $item->excerpt ?? '') }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Contenu</label>
            <textarea name="body" class="form-control" rows="10">{{ old('body', $item->body ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Image hero</label>
            <input type="file" name="hero_image" class="form-control">
            @if(!empty($item->hero_image))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $item->hero_image) }}" alt="" style="max-height:120px;" class="rounded">
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label">Image contenu</label>
            <input type="file" name="cover_image" class="form-control">
            @if(!empty($item->cover_image))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="" style="max-height:120px;" class="rounded">
                </div>
            @endif
        </div>
    </div>
</div>
