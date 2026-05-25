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
        <!-- <div class="col-md-6">
            <label class="form-label">Auteur</label>
            <input type="text" name="author" class="form-control" value="{{ old('author', $item->author ?? '') }}" placeholder="Admin">
        </div> -->
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
            <label class="form-label">Petit Contenu</label>
            <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $item->excerpt ?? '') }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Contenu</label>
            <textarea name="body" class="form-control" rows="10">{{ old('body', $item->body ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Image hero</label>
            <div class="form-text mb-2">
                Image utilisée en priorité dans le hero de la page détail. Si elle est vide, le site utilise l'image contenu de l'actualité. Si aucune image n'est envoyée, aucun visuel n'est affiché et le hero devient plus petit.
            </div>
            <input type="file" name="hero_image" class="form-control">
            @if(!empty($item->hero_image))
                <div class="mt-2">
                    <img src="{{ media_url($item->hero_image) }}" alt="" style="max-height:120px;" class="rounded">
                </div>
                @if($isEdit)
                    <div class="mt-2">
                        <button type="button" class="badge border-0 bg-danger js-remove-news-image" data-form-id="remove-news-hero-image-form">
                            Supprimer
                        </button>
                    </div>
                @endif
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label">Image contenu</label>
            <div class="form-text mb-2">
                Cette image sert dans le contenu de l'actualité et elle est aussi utilisée dans le hero si aucune image hero n'est définie.
            </div>
            <input type="file" name="cover_image" class="form-control">
            @if(!empty($item->cover_image))
                <div class="mt-2">
                    <img src="{{ media_url($item->cover_image) }}" alt="" style="max-height:120px;" class="rounded">
                </div>
                @if($isEdit)
                    <div class="mt-2">
                        <button type="button" class="badge border-0 bg-danger js-remove-news-image" data-form-id="remove-news-cover-image-form">
                            Supprimer
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
